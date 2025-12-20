<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CHECKING MENU CATEGORIES AND PREORDER LOGIC ===\n\n";

// Get all categories
$categories = App\Models\Category::all();
echo "All categories:\n";
foreach ($categories as $cat) {
    echo "- ID: {$cat->id}, Name: '{$cat->nama_kategori}'\n";
}

echo "\n=== CHECKING MENUS BY TENANT ===\n";

$tenants = App\Models\Tenant::with(['menus.category'])->get();

foreach ($tenants as $tenant) {
    echo "\n--- {$tenant->nama_tenant} (ID: {$tenant->id}) ---\n";

    $menus = $tenant->menus()->where('is_available', 1)->get();

    if ($menus->count() === 0) {
        echo "  No available menus\n";
        continue;
    }

    foreach ($menus as $menu) {
        $isHeavyMeal = $menu->isHeavyMeal();
        $requiresPreorder = $menu->requiresPreorder();

        echo "  Menu: {$menu->nama_menu}\n";
        echo "    Category: " . ($menu->category ? $menu->category->nama_kategori : 'No category') . "\n";
        echo "    Heavy Meal: " . ($isHeavyMeal ? 'YES' : 'NO') . "\n";
        echo "    Requires Preorder: " . ($requiresPreorder ? 'YES' : 'NO') . "\n";
        echo "    Can Order Now: " . ($menu->canOrderNow() ? 'YES' : 'NO') . "\n";

        if ($requiresPreorder) {
            echo "    Preorder Deadline: " . $menu->getPreorderDeadlineMessage() . "\n";
        }

        echo "\n";
    }
}

echo "=== PREORDER-ELIGIBLE MENUS ===\n";
$preorderMenus = App\Models\Menu::with(['category', 'tenant'])
    ->where('is_available', 1)
    ->get()
    ->filter(function($menu) {
        return $menu->requiresPreorder();
    });

echo "Total preorder-eligible menus: {$preorderMenus->count()}\n";
foreach ($preorderMenus as $menu) {
    echo "- {$menu->nama_menu} ({$menu->tenant->nama_tenant}) - {$menu->category->nama_kategori}\n";
}

echo "\n=== RECENT ORDERS BY USER ===\n";
$users = App\Models\User::whereIn('name', ['Iwan Firmansyah', 'Customer Demo'])->get();

foreach ($users as $user) {
    echo "\n--- {$user->name} (ID: {$user->id}) ---\n";
    $orders = $user->orders()->with('tenant')->orderBy('created_at', 'desc')->take(5)->get();

    foreach ($orders as $order) {
        echo "  Order: {$order->kode_pesanan} (Type: {$order->order_type}, Status: {$order->status})\n";
        echo "    Tenant: {$order->tenant->nama_tenant}\n";
    }
}