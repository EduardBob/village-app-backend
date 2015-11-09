<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVillageSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('village__sms', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('village_id')->unsigned();
            $table->foreign('village_id')->references('id')->on('village__villages')->onDelete('cascade');
            $table->string('phone', 14);
            $table->string('text');
            $table->string('sender');
            $table->dateTime('scheduled_at');
            $table->string('queue_name', 16);
            $table->integer('internal_id');
            $table->string('status', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('village__sms');
    }
}
