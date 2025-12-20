<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CHECKING USERS AND TENANTS ===\n\n";

// Check all users
echo "=== ALL USERS ===\n";
$users = App\Models\User::all();
echo "Total users: {$users->count()}\n";
foreach ($users as $user) {
    $role = isset($user->role) ? $user->role : 'null';
    echo "ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Role: {$role}\n";
}

echo "\n=== ALL TENANTS ===\n";
$tenants = App\Models\Tenant::all();
echo "Total tenants: {$tenants->count()}\n";
foreach ($tenants as $tenant) {
    echo "ID: {$tenant->id}, Name: {$tenant->nama_tenant}, User ID: {$tenant->user_id}\n";
    $user = $tenant->user;
    if ($user) {
        $userRole = isset($user->role) ? $user->role : 'null';
        echo "  -> User: {$user->name} (Role: {$userRole})\n";
    } else {
        echo "  -> No user linked!\n";
    }
}

echo "\n=== ORDERS BY TENANT ===\n";
$orders = App\Models\Order::with('tenant')->get();
foreach ($orders as $order) {
    echo "Order {$order->id} ({$order->kode_pesanan}): Tenant {$order->tenant->nama_tenant} (ID: {$order->tenant_id}), Type: {$order->order_type}\n";
}