<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSecurityLinkToVillageVillagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('village__villages', function (Blueprint $table) {
            $table->string('open_door_link');
            $table->string('open_barrier_link');
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
            $table->dropColumn('open_door_link');
            $table->dropColumn('open_barrier_link');
        });
    }
}
