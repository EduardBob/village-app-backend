<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentTypeAndStatusColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $statuses = "'" . implode("','", config('village.order.statuses')) . "'";
        $firstStatus = config('village.order.first_status');
        DB::statement("ALTER TABLE village__product_orders CHANGE COLUMN status status ENUM({$statuses}) NOT NULL DEFAULT '{$firstStatus}'");
        DB::statement("ALTER TABLE village__service_orders CHANGE COLUMN status status ENUM({$statuses}) NOT NULL DEFAULT '{$firstStatus}'");

        Schema::table('village__product_orders', function (Blueprint $table) {
            $table
                ->enum('payment_type', config('village.order.payment.type.values'))
                ->default(config('village.order.payment.type.default'))
            ;
            $table
                ->enum('payment_status', config('village.order.payment.status.values'))
                ->default(config('village.order.payment.status.default'))
            ;
        });

        Schema::table('village__service_orders', function (Blueprint $table) {
            $table
                ->enum('payment_type', config('village.order.payment.type.values'))
                ->default(config('village.order.payment.type.default'))
            ;
            $table
                ->enum('payment_status', config('village.order.payment.status.values'))
                ->default(config('village.order.payment.status.default'))
            ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('village__product_orders', function (Blueprint $table) {
            $table->dropColumn('payment_type');
            $table->dropColumn('payment_status');
        });

        Schema::table('village__service_orders', function (Blueprint $table) {
            $table->dropColumn('payment_type');
            $table->dropColumn('payment_status');
        });
    }
}
