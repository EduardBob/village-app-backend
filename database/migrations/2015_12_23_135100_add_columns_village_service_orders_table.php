<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsVillageServiceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('village__service_orders', function (Blueprint $table) {
            $table->string('added_from');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('village__service_orders', function (Blueprint $table) {
            $table->dropColumn('added_from');
            $table->dropColumn('added_to');
        });
    }
}
