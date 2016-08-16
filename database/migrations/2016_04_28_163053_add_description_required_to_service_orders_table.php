<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionRequiredToServiceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('village__service_orders', function (Blueprint $table) {
	        $table->boolean('is_comment_required');
        });

	    Schema::table('village__product_orders', function (Blueprint $table) {
		    $table->boolean('is_comment_required');
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
	        $table->dropColumn('is_comment_required');
        });

	    Schema::table('village__service_orders', function (Blueprint $table) {
		    $table->dropColumn('is_comment_required');
	    });
    }
}
