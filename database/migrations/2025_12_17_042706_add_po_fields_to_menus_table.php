<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->boolean('is_po_based')->default(false)->after('is_available');
            $table->integer('po_minimum_quantity')->default(10)->after('is_po_based');
            $table->integer('po_lead_time_days')->default(3)->after('po_minimum_quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('is_po_based');
            $table->dropColumn('po_minimum_quantity');
            $table->dropColumn('po_lead_time_days');
        });
    }
};
