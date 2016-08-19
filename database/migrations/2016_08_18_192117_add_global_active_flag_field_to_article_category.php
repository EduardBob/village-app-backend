<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGlobalActiveFlagFieldToArticleCategory extends Migration
{
    /**
     * Run the migrations.
     *
     *
     * @return void
     */
    public function up()
    {
        Schema::table('village__article_categories', function (Blueprint $table) {
            $table->boolean('is_global')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('village__article_categories', function (Blueprint $table) {
            $table->dropColumn('is_global');
        });
    }
}
