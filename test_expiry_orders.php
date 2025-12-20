<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TESTING ORDER EXPIRY SYSTEM ===\n\n";

$customer = App\Models\User::where('role', 'customer')->first();
$tenant = App\Models\Tenant::find(4); // Kantin Makanan Berat
$menu = $tenant->menus()->where('is_available', 1)->first();

echo "Creating test orders with different ages...\n";

// 1. Fresh regular order (should show)
$regularFresh = App\Models\Order::create([
    'kode_pesanan' => 'ORD-REGULAR-FRESH-' . now()->format('Ymd-His'),
    'tenant_id' => 4,
    'user_id' => $customer->id,
    'total_harga' => $menu->harga,
    'status' => 'selesai',
    'order_type' => 'regular',
    'created_at' => now()->subMinutes(30), // 30 minutes ago
    'catatan' => 'Test fresh regular order'
]);

App\Models\OrderItem::create([
    'order_id' => $regularFresh->id,
    'menu_id' => $menu->id,
    'quantity' => 1,
    'harga' => $menu->harga,
    'subtotal' => $menu->harga
]);

echo "✅ Fresh regular order: {$regularFresh->kode_pesanan}\n";

// 2. Expired regular order (should be hidden by default)
$regularExpired = App\Models\Order::create([
    'kode_pesanan' => 'ORD-REGULAR-EXP-' . now()->format('Ymd-His'),
    'tenant_id' => 4,
    'user_id' => $customer->id,
    'total_harga' => $menu->harga,
    'status' => 'selesai',
    'order_type' => 'regular',
    'created_at' => now()->subDays(2), // 2 days ago
    'catatan' => 'Test expired regular order'
]);

App\Models\OrderItem::create([
    'order_id' => $regularExpired->id,
    'menu_id' => $menu->id,
    'quantity' => 1,
    'harga' => $menu->harga,
    'subtotal' => $menu->harga
]);

echo "✅ Expired regular order: {$regularExpired->kode_pesanan}\n";

// 3. Fresh preorder (should show)
$preorderFresh = App\Models\Order::create([
    'kode_pesanan' => 'PO-PO-FRESH-' . now()->format('Ymd-His'),
    'tenant_id' => 4,
    'user_id' => $customer->id,
    'total_harga' => $menu->harga * 2,
    'status' => 'selesai',
    'order_type' => 'preorder',
    'delivery_date' => now()->addHours(6), // Due in 6 hours
    'created_at' => now()->subMinutes(45),
    'catatan' => 'Test fresh preorder'
]);

App\Models\OrderItem::create([
    'order_id' => $preorderFresh->id,
    'menu_id' => $menu->id,
    'quantity' => 2,
    'harga' => $menu->harga,
    'subtotal' => $menu->harga * 2
]);

echo "✅ Fresh preorder: {$preorderFresh->kode_pesanan}\n";

// 4. Expired preorder (delivery was yesterday)
$preorderExpired = App\Models\Order::create([
    'kode_pesanan' => 'PO-PO-EXP-' . now()->format('Ymd-His'),
    'tenant_id' => 4,
    'user_id' => $customer->id,
    'total_harga' => $menu->harga * 2,
    'status' => 'selesai',
    'order_type' => 'preorder',
    'delivery_date' => now()->subDays(2), // Delivery was 2 days ago
    'created_at' => now()->subDays(3), // Created 3 days ago
    'catatan' => 'Test expired preorder'
]);

App\Models\OrderItem::create([
    'order_id' => $preorderExpired->id,
    'menu_id' => $menu->id,
    'quantity' => 2,
    'harga' => $menu->harga,
    'subtotal' => $menu->harga * 2
]);

echo "✅ Expired preorder: {$preorderExpired->kode_pesanan}\n";

echo "\n=== TESTING EXPIRY METHODS ===\n";

$testOrders = [$regularFresh, $regularExpired, $preorderFresh, $preorderExpired];

foreach ($testOrders as $order) {
    echo "\nOrder: {$order->kode_pesanan}\n";
    echo "Type: {$order->order_type}\n";
    echo "Status: {$order->status}\n";
    echo "Created: {$order->created_at}\n";
    if ($order->delivery_date) {
        echo "Delivery: {$order->delivery_date}\n";
    }
    echo "Is Expired: " . ($order->isExpired() ? 'YES' : 'NO') . "\n";
    echo "Expiry Date: " . $order->getExpiryDate() . "\n";
    echo "Remaining Time: " . $order->getRemainingTime() . "\n";
}

echo "\n=== TESTING CONTROLLER LOGIC ===\n";
$activeOrders = $tenant->orders()->active()->count();
$allOrders = $tenant->orders()->count();

echo "Active orders (should show): {$activeOrders}\n";
echo "All orders: {$allOrders}\n";
echo "Hidden expired orders: " . ($allOrders - $activeOrders) . "\n";

echo "\n✅ Test completed! Refresh browser to see expiry system in action.\n";
echo "- Default view: Only active orders\n";
echo "- Click 'Tampilkan Semua' to see expired orders\n";