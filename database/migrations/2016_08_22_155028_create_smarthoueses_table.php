<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSmarthouesesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('village__smarthouses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('password');
            $table->string('name');
            $table->string('api');
            $table->boolean('active')->default(true);
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('village__smarthouses', function (Blueprint $table) {
           // $table->dropForeign('village__smarthouses_user_id_foreign');
        });
        Schema::dropIfExists('village__smarthouses');
    }
}
