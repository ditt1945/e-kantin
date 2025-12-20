<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DEBUGGING TENANT ORDERS VIEW ===\n\n";

// Simulate tenant user (first tenant user)
$tenantUser = App\Models\User::where('role', 'tenant')->first();
if (!$tenantUser) {
    echo "No tenant user found!\n";
    exit;
}

echo "Tenant User: {$tenantUser->name}\n";

// Get tenant from user
$tenant = $tenantUser->tenant;
if (!$tenant) {
    echo "User has no tenant!\n";
    exit;
}

echo "Tenant: {$tenant->nama_tenant} (ID: {$tenant->id})\n\n";

// Get orders like in the controller
echo "=== ORDERS QUERY (like TenantDashboardController::orders) ===\n";
$query = $tenant->orders()
    ->with(['user', 'orderItems.menu', 'payment']);

// Show all orders first
$allOrders = $query->get();
echo "Total orders for this tenant: {$allOrders->count()}\n\n";

foreach ($allOrders as $order) {
    echo "----------------------------------------\n";
    echo "Order ID: {$order->id}\n";
    echo "Kode: {$order->kode_pesanan}\n";
    echo "Type: {$order->order_type}\n";
    echo "Status: {$order->status}\n";
    echo "Delivery: {$order->delivery_date}\n";
    echo "User: {$order->user->name}\n";

    // Check if preorder logic would work
    $isPreorder = $order->order_type === 'preorder';
    echo "Would show as preorder: " . ($isPreorder ? 'YES' : 'NO') . "\n";

    if ($isPreorder) {
        echo ">>> SHOULD SHOW 'Pre-Order' BADGE <<<\n";
    } else {
        echo ">>> SHOULD SHOW 'Langsung' BADGE <<<\n";
    }
}

echo "\n=== TESTING SPECIFIC PREORDER FILTER ===\n";
$preordersOnly = $query->where('order_type', 'preorder')->get();
echo "Preorders only: {$preordersOnly->count()}\n";

echo "\n=== TESTING STATUS FILTER ===\n";
$pendingOrders = $query->where('status', 'pending')->get();
echo "Pending orders: {$pendingOrders->count()}\n";

echo "\n=== TESTING TYPE FILTER (preorder) ===\n";
$preorderFilter = $query->where('order_type', 'preorder')->get();
echo "Preorder type filter: {$preorderFilter->count()}\n";

echo "\n=== ACTIVE TYPE VARIABLE SIMULATION ===\n";
$validated = ['type' => 'preorder'];
$activeType = $validated['type'] ?? 'all';
echo "Active type would be: {$activeType}\n";