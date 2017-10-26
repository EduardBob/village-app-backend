<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveMainAdminIdUniqueKeyFromVillageVillagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('village__villages', function (Blueprint $table) {
            $table->dropForeign('village__villages_main_admin_id_foreign');
            $table->dropUnique('village__villages_main_admin_id_unique');
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
            $table->unique('main_admin_id');
//            $table->foreign('main_admin_id')->references('id')->on('users')->onDelete('SET NULL');
        });
    }
}
