<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArticleCatidAndPublicationDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('village__articles', function (Blueprint $table) {
            $table->integer('category_id')->default(1);
            $table->timestamp('published_at');
        });
        DB::statement("UPDATE `village__articles` SET `published_at` = `created_at`");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('village__articles', function (Blueprint $table) {
            $table->dropColumn('category_id');
            $table->dropColumn('published_at');
        });
    }
}
