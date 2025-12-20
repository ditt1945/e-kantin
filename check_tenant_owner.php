<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CHECKING TENANT OWNERS ===\n\n";

$tenantOwners = App\Models\User::where('role', 'tenant_owner')->get();
echo "Total tenant owners: {$tenantOwners->count()}\n\n";

foreach ($tenantOwners as $owner) {
    echo "Owner: {$owner->name} (ID: {$owner->id})\n";
    echo "Email: {$owner->email}\n";
    echo "Tenant ID: " . ($owner->tenant_id ? $owner->tenant_id : 'NULL') . "\n";

    if ($owner->tenant_id) {
        $tenant = $owner->tenant;
        if ($tenant) {
            echo "Linked Tenant: {$tenant->nama_tenant} (ID: {$tenant->id})\n";

            echo "\n=== ORDERS FOR THIS TENANT ===\n";
            $orders = $tenant->orders()->get();
            echo "Total orders: {$orders->count()}\n";

            foreach ($orders as $order) {
                echo "- Order {$order->id}: {$order->kode_pesanan} (Type: {$order->order_type}, Status: {$order->status})\n";
                $isPreorder = $order->order_type === 'preorder';
                echo "  >> Should show badge: " . ($isPreorder ? 'Pre-Order' : 'Langsung') . "\n";
            }
        } else {
            echo "Tenant ID exists but tenant not found!\n";
        }
    } else {
        echo "No tenant linked!\n";
    }
    echo "\n----------------------------------------\n\n";
}

echo "=== TESTING WITH USER ID 2 (Ryuuks) ===\n";
$user2 = App\Models\User::find(2);
if ($user2) {
    echo "User: {$user2->name} (Role: {$user2->role})\n";
    echo "Tenant ID: {$user2->tenant_id}\n";

    if ($user2->tenant) {
        $tenant = $user2->tenant;
        echo "Tenant: {$tenant->nama_tenant}\n";

        echo "\n=== SIMULATING LOGIN AS THIS USER ===\n";
        $orders = $tenant->orders()->with(['user', 'orderItems.menu'])->get();
        echo "Orders this tenant would see: {$orders->count()}\n";

        foreach ($orders as $order) {
            echo "- {$order->kode_pesanan}: {$order->order_type} ({$order->status})\n";
            $isPreorder = $order->order_type === 'preorder';
            echo "  Badge logic: ";
            if ($isPreorder) {
                echo '<span class="badge bg-dark">Pre-Order</span>';
            } else {
                echo '<span class="badge bg-secondary">Langsung</span>';
            }
            echo "\n";
        }
    } else {
        echo "No tenant linked - this is the problem!\n";
    }
}