<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDoneAtInOrderTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('village__service_orders', function (Blueprint $table) {
	        $table->dateTime('done_at')->nullable();
        });
	    DB::statement("UPDATE `village__service_orders` SET `done_at` = `updated_at` WHERE status = 'done';");

	    Schema::table('village__product_orders', function (Blueprint $table) {
		    $table->dateTime('done_at')->nullable();
	    });
	    DB::statement("UPDATE `village__product_orders` SET `done_at` = `updated_at` WHERE status = 'done';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('village__service_orders', function (Blueprint $table) {
            $table->dropColumn('done_at');
        });

	    Schema::table('village__product_orders', function (Blueprint $table) {
		    $table->dropColumn('done_at');
	    });
    }
}
