<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CHECKING CURRENT ORDERS ===\n\n";

// Check all orders
$allOrders = App\Models\Order::orderBy('created_at', 'desc')->take(10)->get();

echo "Latest 10 orders:\n";
foreach ($allOrders as $order) {
    echo "ID: {$order->id}, Kode: {$order->kode_pesanan}, Type: {$order->order_type}, Status: {$order->status}\n";
    echo "  Created: {$order->created_at}\n";
    if ($order->delivery_date) {
        echo "  Delivery: {$order->delivery_date}\n";
    }
    echo "  Tenant: {$order->tenant->nama_tenant}\n";
    echo "  isExpired: " . ($order->isExpired() ? 'YES' : 'NO') . "\n";
    echo "  Remaining: " . $order->getRemainingTime() . "\n";
    echo "\n";
}

// Check specifically for Kantin Makanan Berat (tenant ID 4)
echo "=== ORDERS FOR KANTIN MAKANAN BERAT (ID 4) ===\n";
$tenant4Orders = App\Models\Order::where('tenant_id', 4)
    ->orderBy('created_at', 'desc')
    ->get();

echo "Total orders for Kantin Makanan Berat: {$tenant4Orders->count()}\n\n";

foreach ($tenant4Orders as $order) {
    echo "ID: {$order->id}, Kode: {$order->kode_pesanan}, Type: {$order->order_type}\n";
    echo "  isExpired: " . ($order->isExpired() ? 'YES' : 'NO') . "\n";
    echo "  Should show in active view: " . (!$order->isExpired() ? 'YES' : 'NO') . "\n";
    echo "\n";
}

// Check preorders specifically
echo "=== ALL PREORDERS ===\n";
$preorders = App\Models\Order::where('order_type', 'preorder')
    ->orderBy('created_at', 'desc')
    ->get();

echo "Total preorders: {$preorders->count()}\n\n";
foreach ($preorders as $po) {
    echo "ID: {$po->id}, Kode: {$po->kode_pesanan}\n";
    echo "  Tenant: {$po->tenant->nama_tenant}\n";
    echo "  Status: {$po->status}\n";
    echo "  Delivery: {$po->delivery_date}\n";
    echo "  isExpired: " . ($po->isExpired() ? 'YES' : 'NO') . "\n";
    echo "\n";
}

// Simulate what user should see
echo "=== WHAT USER SHOULD SEE (active orders for tenant 4) ===\n";
$activeOrders = App\Models\Order::where('tenant_id', 4)
    ->active()
    ->orderBy('created_at', 'desc')
    ->get();

echo "Active orders count: {$activeOrders->count()}\n";
foreach ($activeOrders as $order) {
    echo "- {$order->kode_pesanan} ({$order->order_type}) - isPreorder: " . ($order->order_type === 'preorder' ? 'TRUE' : 'FALSE') . "\n";
}