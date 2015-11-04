<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVillageServiceOrderChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('village__service_order_changes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('village__services')->onDelete('CASCADE');
            $table->integer('user_id')->unsigned()->nullable();;
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
        Schema::drop('village__service_order_changes');
    }
}
