<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBaseArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('village__base__articles', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->text('text');
            $table->text('short');
            $table->boolean('active')->default(false);

            $table->timestamps();
        });

        Schema::table('village__articles', function (Blueprint $table) {
            $table->integer('base_id')->unsigned()->nullable();
            $table->foreign('base_id')->references('id')->on('village__base__articles')->onDelete('SET NULL');
            DB::statement("ALTER TABLE `village__articles` CHANGE `active` `active` TINYINT(1) NOT NULL DEFAULT '0';");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('village__articles', function (Blueprint $table) {
            $table->dropForeign('village__articles_base_id_foreign');
            $table->dropColumn('base_id');
        });

        Schema::drop('village__base__articles');
    }
}
