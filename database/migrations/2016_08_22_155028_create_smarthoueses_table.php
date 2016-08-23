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
        Schema::create('village__smart_houses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('password');
            $table->string('name');
            $table->string('api');
            $table->boolean('active')->default(true);
            $table->integer('user_id');
            $table->timestamps();
            $table->softDeletes();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('village__smart_houses');
    }
}
