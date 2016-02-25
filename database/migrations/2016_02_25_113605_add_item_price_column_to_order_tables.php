<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddItemPriceColumnToOrderTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('village__product_orders', function (Blueprint $table) {
            $table->decimal('unit_price', 10, 2);
        });

        Schema::table('village__service_orders', function (Blueprint $table) {
            $table->decimal('unit_price', 10, 2);
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
            $table->dropColumn('unit_price');
        });

        Schema::table('village__service_orders', function (Blueprint $table) {
            $table->dropColumn('unit_price');
        });
    }
}
