<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMainAdminIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('village__villages', function (Blueprint $table) {
            $table->integer('main_admin_id')->unsigned()->nullable()->unique();
            $table->foreign('main_admin_id')->references('id')->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('village__villages', function (Blueprint $table) {
            $table->dropForeign('village__villages_main_admin_id_foreign');
            $table->dropColumn('main_admin_id');
        });
    }
}
