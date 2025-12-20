<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking specific preorder order details:\n\n";

$order = App\Models\Order::find(43);
if ($order) {
    echo "=== ORDER DETAILS ===\n";
    echo "ID: {$order->id}\n";
    echo "Kode: {$order->kode_pesanan}\n";
    echo "Type: {$order->order_type}\n";
    echo "Status: {$order->status}\n";
    echo "Tenant ID: {$order->tenant_id}\n";
    echo "User ID: {$order->user_id}\n";
    echo "Delivery: {$order->delivery_date}\n";
    echo "Is Preorder: " . ($order->isPreorder() ? 'YES' : 'NO') . "\n";
    echo "Order Type Label: " . $order->getOrderTypeLabel() . "\n";

    echo "\n=== TENANT DETAILS ===\n";
    $tenant = $order->tenant;
    if ($tenant) {
        echo "Tenant Name: {$tenant->nama_tenant}\n";
        echo "Tenant ID: {$tenant->id}\n";
    }

    echo "\n=== ALL PREORDERS ===\n";
    $preorders = App\Models\Order::where('order_type', 'preorder')->get();
    echo "Total preorders: {$preorders->count()}\n";
    foreach ($preorders as $po) {
        echo "- PO ID {$po->id}: {$po->kode_pesanan} (Tenant: {$po->tenant->nama_tenant})\n";
    }

    echo "\n=== SIMULATING TENANT VIEW ===\n";
    // Simulate tenant view - check if tenant can see this order
    $someTenant = App\Models\Tenant::find($order->tenant_id);
    if ($someTenant) {
        echo "Tenant: {$someTenant->nama_tenant}\n";
        $tenantOrders = $someTenant->orders()->where('order_type', 'preorder')->get();
        echo "Preorders for this tenant: {$tenantOrders->count()}\n";
        foreach ($tenantOrders as $tOrder) {
            echo "  - {$tOrder->kode_pesanan} (Type: {$tOrder->order_type}, Status: {$tOrder->status})\n";
        }
    }
} else {
    echo "Order not found!\n";
}