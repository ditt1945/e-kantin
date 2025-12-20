<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CREATING TEST PREORDERS FOR MULTIPLE TENANTS ===\n\n";

$customerUser = App\Models\User::where('role', 'customer')->first();
if (!$customerUser) {
    echo "No customer user found!\n";
    exit;
}

// Get all tenants
$tenants = App\Models\Tenant::with('menus')->get();

foreach ($tenants as $tenant) {
    echo "Processing tenant: {$tenant->nama_tenant} (ID: {$tenant->id})\n";

    // Get available menu
    $menu = $tenant->menus()->where('is_available', 1)->first();
    if (!$menu) {
        echo "  -> No available menu, skipping\n";
        continue;
    }

    // Check if already has preorder
    $existingPreorder = App\Models\Order::where('tenant_id', $tenant->id)
        ->where('order_type', 'preorder')
        ->first();

    if ($existingPreorder) {
        echo "  -> Already has preorder: {$existingPreorder->kode_pesanan}\n";
        continue;
    }

    // Create new preorder
    $order = App\Models\Order::create([
        'kode_pesanan' => 'PO-TEST-' . $tenant->id . '-' . now()->format('Ymd-His'),
        'tenant_id' => $tenant->id,
        'user_id' => $customerUser->id,
        'total_harga' => $menu->harga * 2,
        'status' => 'pending',
        'order_type' => 'preorder',
        'delivery_date' => now()->addDay()->format('Y-m-d'),
        'catatan' => "Test preorder for {$tenant->nama_tenant}"
    ]);

    // Create order item
    App\Models\OrderItem::create([
        'order_id' => $order->id,
        'menu_id' => $menu->id,
        'quantity' => 2,
        'harga' => $menu->harga,
        'subtotal' => $menu->harga * 2
    ]);

    echo "  -> Created preorder: {$order->kode_pesanan}\n";
    $menuTotal = $menu->harga * 2;
    echo "     Menu: {$menu->nama_menu} x2 = {$menuTotal}\n";
}

echo "\n=== SUMMARY ===\n";
$preorders = App\Models\Order::where('order_type', 'preorder')->get();
echo "Total preorders now: {$preorders->count()}\n";

foreach ($preorders as $po) {
    echo "- {$po->kode_pesanan}: {$po->tenant->nama_tenant} (Status: {$po->status})\n";
}

echo "\nNow refresh your browser page to see preorders in your tenant!\n";