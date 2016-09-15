<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DocumentsTableCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('village__documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('text');
            $table->text('short');
            $table->integer('category_id')->unsigned()->nullable();
            $table->integer('role_id')->unsigned()->nullable();
            $table->integer('village_id')->unsigned()->nullable();
            $table->foreign('village_id')->references('id')->on('village__villages')->onDelete('CASCADE');
            $table->timestamp('published_at');
            $table->boolean('active')->default(true);
            $table->boolean('is_personal')->default(false);
            $table->boolean('is_protected')->default(false);
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
        Schema::dropIfExists('village__documents');

    }
}
