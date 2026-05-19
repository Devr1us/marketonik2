<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('shipping_status', 32)->default('menunggu')->after('payment_note');
            $table->string('shipping_address')->nullable()->after('shipping_status');
            $table->string('tracking_number')->nullable()->after('shipping_address');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['shipping_status', 'shipping_address', 'tracking_number']);
        });
    }
};
