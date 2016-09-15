<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('village__document_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order')->default(0);
            $table->index('order');
            $table->string('title');
            $table->boolean('active')->default(true);
            $table->boolean('is_global')->default(true);
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
        Schema::dropIfExists('village__document_categories');
    }
}
