<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransactionIdToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('village__product_orders', function (Blueprint $table) {
            $table->string('transaction_id')->nullable();
        });

        Schema::table('village__service_orders', function (Blueprint $table) {
            $table->string('transaction_id')->nullable();
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
            $table->dropColumn('transaction_id');
        });

        Schema::table('village__service_orders', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
        });
    }
}
