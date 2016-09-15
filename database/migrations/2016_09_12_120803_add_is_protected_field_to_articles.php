<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsProtectedFieldToArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('village__articles', function (Blueprint $table) {
            $table->boolean('is_protected')->default(false);
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
            $table->dropColumn('is_protected');
        });
    }
}
