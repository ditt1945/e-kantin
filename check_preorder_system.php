<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking preorder system...\n\n";

// Check if preorder columns exist
echo "=== ORDER TABLE COLUMNS ===\n";
$columns = Schema::getColumnListing('orders');
echo "Columns found: " . implode(', ', $columns) . "\n\n";

echo "=== CHECKING PREORDER COLUMNS ===\n";
$hasOrderType = Schema::hasColumn('orders', 'order_type');
$hasDeliveryDate = Schema::hasColumn('orders', 'delivery_date');
$hasPreorderNotes = Schema::hasColumn('orders', 'preorder_notes');

echo "Has order_type: " . ($hasOrderType ? "YES" : "NO") . "\n";
echo "Has delivery_date: " . ($hasDeliveryDate ? "YES" : "NO") . "\n";
echo "Has preorder_notes: " . ($hasPreorderNotes ? "YES" : "NO") . "\n\n";

// Check sample orders
echo "=== SAMPLE ORDERS ===\n";
$orders = App\Models\Order::take(5)->get(['id', 'order_type', 'delivery_date', 'status', 'kode_pesanan']);

foreach($orders as $order) {
    echo "ID: {$order->id}, Type: {$order->order_type}, Delivery: {$order->delivery_date}, Status: {$order->status}, Kode: {$order->kode_pesanan}\n";
}

echo "\n=== PREORDER ORDERS COUNT ===\n";
$preorderCount = App\Models\Order::where('order_type', 'preorder')->count();
echo "Total preorder orders: {$preorderCount}\n";

$regularCount = App\Models\Order::where('order_type', 'regular')->count();
echo "Total regular orders: {$regularCount}\n";

echo "\n=== ORDERS WITH DELIVERY DATE ===\n";
$withDeliveryDate = App\Models\Order::whereNotNull('delivery_date')->count();
echo "Orders with delivery date: {$withDeliveryDate}\n";

echo "\nDone.\n";