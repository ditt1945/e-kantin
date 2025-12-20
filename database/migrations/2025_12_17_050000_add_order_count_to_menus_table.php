<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->integer('order_count')->default(0)->after('stok');
            $table->decimal('total_revenue', 15, 2)->default(0)->after('order_count');

            // Add indexes for performance
            $table->index('order_count');
            $table->index('total_revenue');
        });
    }

    public function down()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropIndex(['order_count']);
            $table->dropIndex(['total_revenue']);
            $table->dropColumn(['order_count', 'total_revenue']);
        });
    }
};