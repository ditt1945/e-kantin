<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedInteger('discount_amount')->default(0)->after('amount');
            $table->string('voucher_code')->nullable()->after('payment_method');
            $table->json('voucher_details')->nullable()->after('voucher_code');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['discount_amount', 'voucher_code', 'voucher_details']);
        });
    }
};
