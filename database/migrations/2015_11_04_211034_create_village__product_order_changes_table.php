<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVillageProductOrderChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('village__product_order_changes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('village__products')->onDelete('CASCADE');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->enum('status', config('village.order.statuses'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('village__product_order_changes');
    }
}
