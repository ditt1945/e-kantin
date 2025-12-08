<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Use raw SQL to modify the enum column
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('customer', 'tenant_owner', 'admin') DEFAULT 'customer'");
    }

    public function down(): void
    {
        // Revert back to original enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('customer', 'tenant_owner') DEFAULT 'customer'");
    }
};
