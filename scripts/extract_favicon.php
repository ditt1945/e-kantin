<?php
// Extract favicon_io.zip and place required files into public/

$publicDir = __DIR__ . '/../public';
$zipPath = $publicDir . '/favicon_io.zip';

if (!file_exists($zipPath)) {
    fwrite(STDERR, "ZIP not found: $zipPath\n");
    exit(1);
}

$zip = new ZipArchive();
if ($zip->open($zipPath) !== true) {
    fwrite(STDERR, "Failed to open ZIP: $zipPath\n");
    exit(1);
}

$tmpExtract = sys_get_temp_dir() . '/favicon_io_' . uniqid();
@mkdir($tmpExtract);

if (!$zip->extractTo($tmpExtract)) {
    fwrite(STDERR, "Failed to extract ZIP to $tmpExtract\n");
    $zip->close();
    exit(1);
}
$zip->close();

// Map expected files
$filesMap = [
    // source => destination
    'apple-touch-icon.png' => $publicDir . '/apple-touch-icon.png',
    'android-chrome-192x192.png' => $publicDir . '/favicon-192.png',
    'favicon.ico' => $publicDir . '/favicon.ico',
];

$found = 0;
foreach ($filesMap as $src => $dest) {
    // Find file recursively in extracted dir
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($tmpExtract));
    $sourcePath = null;
    foreach ($iterator as $file) {
        if ($file->isFile() && basename($file->getPathname()) === $src) {
            $sourcePath = $file->getPathname();
            break;
        }
    }

    if (!$sourcePath) {
        fwrite(STDERR, "Missing in ZIP: $src\n");
        continue;
    }

    if (!copy($sourcePath, $dest)) {
        fwrite(STDERR, "Failed to copy $src to $dest\n");
        continue;
    }
    $found++;
    echo "Placed: $dest\n";
}

// Cleanup temp dir
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($tmpExtract, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST);
foreach ($iterator as $file) {
    if ($file->isDir()) {
        @rmdir($file->getPathname());
    } else {
        @unlink($file->getPathname());
    }
}
@rmdir($tmpExtract);

if ($found === 0) {
    fwrite(STDERR, "No expected files found in ZIP.\n");
    exit(1);
}

echo "Done. Extracted $found favicon files to public/.\n";
