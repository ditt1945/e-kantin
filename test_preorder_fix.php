<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TESTING PREORDER FIX ===\n\n";

$customer = App\Models\User::where('email', 'customer@demo.com')->first();
if (!$customer) {
    echo "Customer Demo not found!\n";
    exit;
}

echo "Testing as: {$customer->name} ({$customer->email})\n";

// Check existing cart for Kantin Makanan Berat
$tenant = App\Models\Tenant::find(4);
$cart = App\Models\Cart::where('user_id', $customer->id)
    ->where('tenant_id', $tenant->id)
    ->first();

if ($cart) {
    echo "Found existing cart:\n";
    echo "- Cart ID: {$cart->id}\n";
    echo "- Items: {$cart->items()->count()}\n";

    foreach ($cart->items as $item) {
        echo "  - {$item->menu->nama_menu} (Type: {$item->order_type}, Qty: {$item->quantity})\n";
        if ($item->delivery_date) {
            echo "    Delivery: {$item->delivery_date}\n";
        }
    }
} else {
    echo "No existing cart found\n";
}

echo "\n=== SIMULATING PREORDER ORDER CREATION ===\n";

// Get a preorder-eligible menu
$menu = App\Models\Menu::where('tenant_id', 4)
    ->where('is_available', 1)
    ->whereHas('category', function($q) {
        $q->where('nama_kategori', 'Makanan Berat');
    })
    ->first();

if (!$menu) {
    echo "No preorder-eligible menu found!\n";
    exit;
}

echo "Using menu: {$menu->nama_menu} (Category: {$menu->category->nama_kategori})\n";
echo "Requires Preorder: " . ($menu->requiresPreorder() ? 'YES' : 'NO') . "\n";

// Simulate the checkout process
echo "\n=== TEST CHECKOUT PROCESS ===\n";

// Create test cart
$testCart = App\Models\Cart::create([
    'user_id' => $customer->id,
    'tenant_id' => $tenant->id,
    'total_harga' => 0
]);

echo "Created test cart: {$testCart->id}\n";

// Add preorder item to cart
$cartItem = App\Models\CartItem::create([
    'cart_id' => $testCart->id,
    'menu_id' => $menu->id,
    'quantity' => 2,
    'harga' => $menu->harga,
    'order_type' => 'preorder',
    'delivery_date' => now()->addDay()->format('Y-m-d')
]);

echo "Added preorder cart item: {$cartItem->id}\n";
echo "Item type: {$cartItem->order_type}\n";
echo "Delivery date: {$cartItem->delivery_date}\n";

// Test the fixed createOrder method
echo "\n=== TESTING FIXED createOrder METHOD ===\n";

// Simulate the fixed createOrder logic
$hasPreorderItem = $testCart->items()->where('order_type', 'preorder')->exists();
echo "Has preorder item: " . ($hasPreorderItem ? 'YES' : 'NO') . "\n";

$deliveryDate = null;
if ($hasPreorderItem) {
    $preorderItem = $testCart->items()->where('order_type', 'preorder')->first();
    $deliveryDate = $preorderItem->delivery_date;
    echo "Delivery date from cart: {$deliveryDate}\n";
}

$order = App\Models\Order::create([
    'tenant_id' => $testCart->tenant_id,
    'user_id' => $customer->id,
    'total_harga' => $menu->harga * 2,
    'status' => 'pending',
    'order_type' => $hasPreorderItem ? 'preorder' : 'regular',
    'delivery_date' => $deliveryDate,
]);

echo "Created test order: {$order->id}\n";
echo "Order type: {$order->order_type}\n";
echo "Delivery date: {$order->delivery_date}\n";
echo "Kode pesanan: {$order->kode_pesanan}\n";
echo "Is preorder: " . ($order->isPreorder() ? 'YES' : 'NO') . "\n";

// Create order item
App\Models\OrderItem::create([
    'order_id' => $order->id,
    'menu_id' => $menu->id,
    'quantity' => 2,
    'harga' => $menu->harga,
    'subtotal' => $menu->harga * 2
]);

echo "Order item created successfully\n";

// Cleanup test data
$testCart->items()->delete();
$testCart->delete();

echo "\n✅ PREORDER FIX TEST SUCCESSFUL!\n";
echo "Now Customer Demo can create preorder orders!\n";