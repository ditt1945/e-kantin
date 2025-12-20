<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CREATING PREORDER FOR KANTIN MAKANAN BERAT ===\n\n";

$customer = App\Models\User::where('role', 'customer')->first();
$tenant = App\Models\Tenant::find(4); // Kantin Makanan Berat
$menu = $tenant->menus()->where('is_available', 1)->first();

echo "Creating preorder for: {$tenant->nama_tenant}\n";
echo "Customer: {$customer->name}\n";
echo "Menu: {$menu->nama_menu}\n";

$order = App\Models\Order::create([
    'kode_pesanan' => 'PO-MAKANAN-' . now()->format('Ymd-His'),
    'tenant_id' => 4,
    'user_id' => $customer->id,
    'total_harga' => $menu->harga * 2,
    'status' => 'pending',
    'order_type' => 'preorder',
    'delivery_date' => now()->addDay()->format('Y-m-d'),
    'catatan' => 'Test preorder untuk Kantin Makanan Berat'
]);

App\Models\OrderItem::create([
    'order_id' => $order->id,
    'menu_id' => $menu->id,
    'quantity' => 2,
    'harga' => $menu->harga,
    'subtotal' => $menu->harga * 2
]);

echo "Created: {$order->kode_pesanan} (ID: {$order->id})\n";
echo "Type: {$order->order_type}\n";
echo "Delivery: {$order->delivery_date}\n\n";

echo "Refresh browser to see this preorder!\n";