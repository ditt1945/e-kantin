<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Creating test preorder...\n\n";

// Get tenant
$tenant = App\Models\Tenant::first();
if (!$tenant) {
    echo "No tenant found!\n";
    exit;
}

// Get customer user
$user = App\Models\User::where('role', 'customer')->first();
if (!$user) {
    echo "No customer user found!\n";
    exit;
}

// Get menu that requires preorder (heavy meal)
$menu = App\Models\Menu::where('tenant_id', $tenant->id)
    ->where('is_available', 1)
    ->first();

if (!$menu) {
    echo "No available menu found!\n";
    exit;
}

echo "Testing with:\n";
echo "- Tenant: {$tenant->nama_tenant}\n";
echo "- Customer: {$user->name}\n";
echo "- Menu: {$menu->nama_menu}\n";
echo "- Menu requires preorder: " . ($menu->requiresPreorder() ? 'YES' : 'NO') . "\n\n";

// Create preorder order
$order = App\Models\Order::create([
    'kode_pesanan' => 'PO-TEST-' . now()->format('Ymd-His'),
    'tenant_id' => $tenant->id,
    'user_id' => $user->id,
    'total_harga' => $menu->harga * 2, // Order 2 items
    'status' => 'pending',
    'order_type' => 'preorder',
    'delivery_date' => now()->addDay()->format('Y-m-d'),
    'catatan' => 'Test preorder order'
]);

// Create order item
App\Models\OrderItem::create([
    'order_id' => $order->id,
    'menu_id' => $menu->id,
    'quantity' => 2,
    'harga' => $menu->harga,
    'subtotal' => $menu->harga * 2
]);

echo "✅ Test preorder created successfully!\n";
echo "Order ID: {$order->id}\n";
echo "Order Code: {$order->kode_pesanan}\n";
echo "Order Type: {$order->order_type}\n";
echo "Delivery Date: {$order->delivery_date}\n";
echo "Status: {$order->status}\n\n";

echo "Now check tenant orders page to see this preorder!\n";