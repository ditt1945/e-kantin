<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tenant;
use App\Models\Menu;

echo "=== DAFTAR TENANT ===\n";
$tenants = Tenant::with('menus')->get();
$heavyMealTenants = [];

foreach($tenants as $tenant) {
    echo sprintf("ID: %d | %s | Email: %s | Menu: %d\n",
        $tenant->id,
        $tenant->nama_tenant,
        $tenant->user->email ?? 'No Email',
        $tenant->menus->count()
    );

    // Cek menu makanan berat
    $heavyMeals = $tenant->menus()->where(function($query) {
        $query->where('nama_menu', 'like', '%nasi%')
               ->orWhere('nama_menu', 'like', '%ayam%')
               ->orWhere('nama_menu', 'like', '%bebek%')
               ->orWhere('nama_menu', 'like', '%sapi%')
               ->orWhere('nama_menu', 'like', '%kambing%')
               ->orWhere('nama_menu', 'like', '%ikan%')
               ->orWhere('nama_menu', 'like', '%seafood%')
               ->orWhere('nama_menu', 'like', '%katering%')
               ->orWhere('nama_menu', 'like', '%box%')
               ->orWhere('nama_menu', 'like', '%koti%')
               ->orWhere('nama_menu', 'like', '%rice%')
               ->orWhere('nama_menu', 'like', '%mie%')
               ->orWhere('nama_menu', 'like', '%bakmi%')
               ->orWhere('nama_menu', 'like', '%bakso%')
               ->orWhere('nama_menu', 'like', '%soto%')
               ->orWhere('nama_menu', 'like', '%gudeg%')
               ->orWhere('nama_menu', 'like', '%rawon%')
               ->orWhere('nama_menu', 'like', '%rendang%')
               ->orWhere('nama_menu', 'like', '%steak%');
    })->get();

    if($heavyMeals->count() > 0) {
        $heavyMealTenants[] = [
            'tenant' => $tenant,
            'heavy_meals' => $heavyMeals
        ];

        echo "  -> MENU MAKANAN BERAT DITEMUKAN:\n";
        foreach($heavyMeals as $menu) {
            echo sprintf("     - %s (Rp %s)\n", $menu->nama_menu, number_format($menu->harga, 0, ',', '.'));
        }
    }
    echo "\n";
}

echo "\n=== CARI TENANT tenant@demo.com ===\n";
$demoTenant = Tenant::whereHas('user', function($query) {
    $query->where('email', 'tenant@demo.com');
})->first();

if($demoTenant) {
    echo sprintf("Tenant demo ditemukan: ID %d | %s\n", $demoTenant->id, $demoTenant->nama_tenant);
    echo sprintf("Current menu count: %d\n", $demoTenant->menus->count());

    if($demoTenant->menus->count() > 0) {
        echo "Menu saat ini:\n";
        foreach($demoTenant->menus as $menu) {
            echo sprintf("  - %s (Rp %s)\n", $menu->nama_menu, number_format($menu->harga, 0, ',', '.'));
        }
    }
} else {
    echo "Tenant dengan email tenant@demo.com tidak ditemukan!\n";
}

echo "\n=== REKOMENDASI PEMINDAHAN ===\n";
if(!empty($heavyMealTenants)) {
    echo "Tenant yang menjual makanan berat ditemukan:\n";
    foreach($heavyMealTenants as $data) {
        $tenant = $data['tenant'];
        $heavyMeals = $data['heavy_meals'];

        echo sprintf("- %s (ID: %d) - %d menu makanan berat\n",
            $tenant->nama_tenant,
            $tenant->id,
            $heavyMeals->count()
        );
        echo "  Email: " . ($tenant->user->email ?? 'No Email') . "\n";
    }

    if($demoTenant) {
        echo "\nApakah Anda ingin memindahkan kepemilikan tenant@demo.com ke tenant makanan berat? (y/n)";
    }
} else {
    echo "Tidak ada tenant yang menjual makanan berat ditemukan.\n";
}