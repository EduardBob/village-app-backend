<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToServiceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('village__service_orders', function (Blueprint $table) {
            $table->text('phone')->nullable();
	        $table->text('admin_comment')->nullable();
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
            $table->dropColumn('phone');
	        $table->dropColumn('admin_comment');
        });
    }
}
