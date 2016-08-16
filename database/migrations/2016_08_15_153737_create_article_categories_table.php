<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('village__article_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order')->default(0);
            $table->index('order');
            $table->string('title');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
        });

        DB::statement("INSERT INTO `village__article_categories` (`title`, `order`) VALUES ('Общая категория', '1')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('village__article_categories');
    }
}
