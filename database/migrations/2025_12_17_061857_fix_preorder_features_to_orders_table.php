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
        Schema::table('orders', function (Blueprint $table) {
            // Add columns if they don't exist
            if (!Schema::hasColumn('orders', 'order_type')) {
                $table->enum('order_type', ['regular', 'preorder'])->default('regular')->after('status');
            }
            if (!Schema::hasColumn('orders', 'delivery_date')) {
                $table->date('delivery_date')->nullable()->after('order_type');
            }
            if (!Schema::hasColumn('orders', 'preorder_notes')) {
                $table->text('preorder_notes')->nullable()->after('catatan');
            }

            // Add index if not exists
            $table->index(['order_type', 'delivery_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['order_type', 'delivery_date']);
            if (Schema::hasColumn('orders', 'order_type')) {
                $table->dropColumn('order_type');
            }
            if (Schema::hasColumn('orders', 'delivery_date')) {
                $table->dropColumn('delivery_date');
            }
            if (Schema::hasColumn('orders', 'preorder_notes')) {
                $table->dropColumn('preorder_notes');
            }
        });
    }
};
