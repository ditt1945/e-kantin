<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== TENANT DATABASE INFO ===\n";

// Query tenant data
$tenants = DB::table('tenants')
    ->leftJoin('users', 'tenants.user_id', '=', 'users.id')
    ->select(
        'tenants.id',
        'tenants.nama_tenant',
        'tenants.user_id',
        'users.name as user_name',
        'users.email as user_email',
        'tenants.is_active'
    )
    ->get();

foreach($tenants as $tenant) {
    echo sprintf("ID: %d | %s | Email: %s | Active: %s\n",
        $tenant->id,
        $tenant->nama_tenant,
        $tenant->user_email ?? 'No Email',
        $tenant->is_active ? 'Yes' : 'No'
    );
}

echo "\n=== FIND tenant@demo.com ===\n";
$userDemo = DB::table('users')->where('email', 'tenant@demo.com')->first();

if($userDemo) {
    echo "Found user: ID {$userDemo->id} | {$userDemo->email}\n";
    $tenantDemo = DB::table('tenants')->where('user_id', $userDemo->id)->first();
    if($tenantDemo) {
        echo "Current tenant: ID {$tenantDemo->id} | {$tenantDemo->nama_tenant}\n";
    } else {
        echo "No tenant assigned to this user!\n";
    }
} else {
    echo "User tenant@demo.com not found in database!\n";
}

echo "\n=== CHECK HEAVY MEALS ===\n";
$menuCounts = DB::table('menus')
    ->select(
        'menus.tenant_id',
        'tenants.nama_tenant',
        DB::raw('COUNT(menus.id) as total_menus'),
        DB::raw('SUM(CASE WHEN
            LOWER(menus.nama_menu) LIKE \'%nasi%\' OR
            LOWER(menus.nama_menu) LIKE \'%ayam%\' OR
            LOWER(menus.nama_menu) LIKE \'%bebek%\' OR
            LOWER(menus.nama_menu) LIKE \'%sapi%\' OR
            LOWER(menus.nama_menu) LIKE \'%kambing%\' OR
            LOWER(menus.nama_menu) LIKE \'%ikan%\' OR
            LOWER(menus.nama_menu) LIKE \'%seafood%\' OR
            LOWER(menus.nama_menu) LIKE \'%katering%\' OR
            LOWER(menus.nama_menu) LIKE \'%box%\' OR
            LOWER(menus.nama_menu) LIKE \'%koti%\' OR
            LOWER(menus.nama_menu) LIKE \'%rice%\' OR
            LOWER(menus.nama_menu) LIKE \'%mie%\' OR
            LOWER(menus.nama_menu) LIKE \'%bakmi%\' OR
            LOWER(menus.nama_menu) LIKE \'%bakso%\' OR
            LOWER(menus.nama_menu) LIKE \'%soto%\' OR
            LOWER(menus.nama_menu) LIKE \'%gudeg%\' OR
            LOWER(menus.nama_menu) LIKE \'%rawon%\' OR
            LOWER(menus.nama_menu) LIKE \'%rendang%\' OR
            LOWER(menus.nama_menu) LIKE \'%steak%\'
        THEN 1 ELSE 0 END) as heavy_meals')
    )
    ->leftJoin('tenants', 'menus.tenant_id', '=', 'tenants.id')
    ->groupBy('menus.tenant_id', 'tenants.nama_tenant')
    ->orderBy('heavy_meals', 'desc')
    ->get();

foreach($menuCounts as $count) {
    if($count->heavy_meals > 0) {
        echo sprintf("Tenant: %s (ID: %d) - %d heavy meals out of %d total menus\n",
            $count->nama_tenant,
            $count->tenant_id,
            $count->heavy_meals,
            $count->total_menus
        );
    }
}

echo "\n=== SPECIFIC HEAVY MEAL MENUS ===\n";
$heavyMenus = DB::table('menus')
    ->select(
        'menus.id',
        'menus.nama_menu',
        'menus.harga',
        'menus.tenant_id',
        'tenants.nama_tenant'
    )
    ->leftJoin('tenants', 'menus.tenant_id', '=', 'tenants.id')
    ->where(function($query) {
        $query->where('menus.nama_menu', 'like', '%nasi%')
               ->orWhere('menus.nama_menu', 'like', '%ayam%')
               ->orWhere('menus.nama_menu', 'like', '%bebek%')
               ->orWhere('menus.nama_menu', 'like', '%sapi%')
               ->orWhere('menus.nama_menu', 'like', '%kambing%')
               ->orWhere('menus.nama_menu', 'like', '%ikan%')
               ->orWhere('menus.nama_menu', 'like', '%seafood%')
               ->orWhere('menus.nama_menu', 'like', '%katering%')
               ->orWhere('menus.nama_menu', 'like', '%box%')
               ->orWhere('menus.nama_menu', 'like', '%koti%')
               ->orWhere('menus.nama_menu', 'like', '%rice%')
               ->orWhere('menus.nama_menu', 'like', '%mie%')
               ->orWhere('menus.nama_menu', 'like', '%bakmi%')
               ->orWhere('menus.nama_menu', 'like', '%bakso%')
               ->orWhere('menus.nama_menu', 'like', '%soto%')
               ->orWhere('menus.nama_menu', 'like', '%gudeg%')
               ->orWhere('menus.nama_menu', 'like', '%rawon%')
               ->orWhere('menus.nama_menu', 'like', '%rendang%')
               ->orWhere('menus.nama_menu', 'like', '%steak%');
    })
    ->get();

foreach($heavyMenus as $menu) {
    echo sprintf("- %s | Tenant: %s (ID: %d) | Rp %s\n",
        $menu->nama_menu,
        $menu->nama_tenant,
        $menu->tenant_id,
        number_format($menu->harga, 0, ',', '.')
    );
}

echo "\n=== RECOMMENDATION ===\n";
$heavyMealTenants = DB::table('menus')
    ->select('menus.tenant_id', 'tenants.nama_tenant')
    ->leftJoin('tenants', 'menus.tenant_id', '=', 'tenants.id')
    ->where(function($query) {
        $query->where('menus.nama_menu', 'like', '%nasi%')
               ->orWhere('menus.nama_menu', 'like', '%ayam%')
               ->orWhere('menus.nama_menu', 'like', '%bebek%');
    })
    ->distinct()
    ->get();

if($heavyMealTenants->count() > 0) {
    echo "Tenants that sell heavy meals:\n";
    foreach($heavyMealTenants as $tenant) {
        echo sprintf("- %s (ID: %d)\n", $tenant->nama_tenant, $tenant->tenant_id);
    }
} else {
    echo "No tenants found with heavy meals.\n";
}