<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== TENANT DAN USER INFO ===\n";

// Query dengan relasi yang benar (user -> tenant)
$tenantUsers = DB::table('users')
    ->leftJoin('tenants', 'users.tenant_id', '=', 'tenants.id')
    ->select(
        'users.id as user_id',
        'users.name as user_name',
        'users.email',
        'users.role',
        'users.tenant_id',
        'tenants.nama_tenant',
        'tenants.is_active as tenant_active'
    )
    ->where('users.role', 'tenant_owner')
    ->get();

foreach($tenantUsers as $user) {
    echo sprintf("User ID: %d | %s | Email: %s | Tenant ID: %d | %s (%s)\n",
        $user->user_id,
        $user->user_name,
        $user->email,
        $user->tenant_id ?? 'NULL',
        $user->nama_tenant ?? 'NO TENANT',
        $user->tenant_active ? 'Active' : 'Inactive'
    );
}

echo "\n=== FIND tenant@demo.com ===\n";
$userDemo = DB::table('users')->where('email', 'tenant@demo.com')->first();

if($userDemo) {
    echo "Found user: ID {$userDemo->id} | {$userDemo->email} | Role: {$userDemo->role}\n";
    echo "Current Tenant ID: " . ($userDemo->tenant_id ?? 'NULL') . "\n";

    if($userDemo->tenant_id) {
        $currentTenant = DB::table('tenants')->where('id', $userDemo->tenant_id)->first();
        if($currentTenant) {
            echo "Current Tenant: {$currentTenant->nama_tenant} (ID: {$currentTenant->id})\n";

            // Cek menu saat ini
            $currentMenus = DB::table('menus')->where('tenant_id', $currentTenant->id)->get();
            echo "Current Menu Count: " . $currentMenus->count() . "\n";
            if($currentMenus->count() > 0) {
                echo "Menus:\n";
                foreach($currentMenus as $menu) {
                    echo "  - {$menu->nama_menu} (Rp " . number_format($menu->harga, 0, ',', '.') . ")\n";
                }
            }
        }
    } else {
        echo "No tenant assigned to this user!\n";
    }
} else {
    echo "User tenant@demo.com not found!\n";
}

echo "\n=== HEAVY MEAL TENANTS ===\n";
// Query tenant dengan makanan berat
$heavyMealTenants = DB::table('tenants')
    ->select(
        'tenants.id',
        'tenants.nama_tenant',
        'tenants.is_active',
        DB::raw('COUNT(DISTINCT menus.id) as total_menus'),
        DB::raw('COUNT(DISTINCT CASE WHEN
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
        THEN menus.id END) as heavy_meal_count')
    )
    ->leftJoin('menus', 'tenants.id', '=', 'menus.tenant_id')
    ->groupBy('tenants.id', 'tenants.nama_tenant', 'tenants.is_active')
    ->havingRaw('heavy_meal_count > 0')
    ->orderBy('heavy_meal_count', 'desc')
    ->get();

foreach($heavyMealTenants as $tenant) {
    echo sprintf("Tenant: %s (ID: %d) | Active: %s | %d heavy meals / %d total menus\n",
        $tenant->nama_tenant,
        $tenant->id,
        $tenant->is_active ? 'Yes' : 'No',
        $tenant->heavy_meal_count,
        $tenant->total_menus
    );
}

echo "\n=== SPECIFIC HEAVY MEAL MENUS ===\n";
$heavyMenus = DB::table('menus')
    ->select(
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
    ->orderBy('tenants.nama_tenant')
    ->orderBy('menus.nama_menu')
    ->get();

foreach($heavyMenus as $menu) {
    echo sprintf("- %s | Rp %s | Tenant: %s (ID: %d)\n",
        $menu->nama_menu,
        number_format($menu->harga, 0, ',', '.'),
        $menu->nama_tenant,
        $menu->tenant_id
    );
}

echo "\n=== RECOMMENDATION ===\n";
if($userDemo && $heavyMealTenants->count() > 0) {
    echo "Recommendation for tenant@demo.com:\n";
    foreach($heavyMealTenants as $tenant) {
        echo sprintf("- Move to: %s (ID: %d) - %d heavy meals available\n",
            $tenant->nama_tenant,
            $tenant->id,
            $tenant->heavy_meal_count
        );
    }

    echo "\nTo execute the change, run this SQL:\n";
    echo "UPDATE users SET tenant_id = [NEW_TENANT_ID] WHERE email = 'tenant@demo.com';\n";
} else {
    echo "No recommendation available.\n";
}