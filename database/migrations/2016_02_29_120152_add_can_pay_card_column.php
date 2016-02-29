<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCanPayCardColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('village__base__products', function (Blueprint $table) {
	        $table->boolean('has_card_payment')->default(true);
        });

	    Schema::table('village__base__services', function (Blueprint $table) {
		    $table->boolean('has_card_payment')->default(true);
	    });

	    Schema::table('village__services', function (Blueprint $table) {
		    $table->boolean('has_card_payment')->default(true);
	    });

	    Schema::table('village__products', function (Blueprint $table) {
		    $table->boolean('has_card_payment')->default(true);
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('village__base__products', function (Blueprint $table) {
	        $table->dropColumn('has_card_payment');
        });

	    Schema::table('village__base__services', function (Blueprint $table) {
		    $table->dropColumn('has_card_payment');
	    });

	    Schema::table('village__services', function (Blueprint $table) {
		    $table->dropColumn('has_card_payment');
	    });

	    Schema::table('village__products', function (Blueprint $table) {
		    $table->dropColumn('has_card_payment');
	    });
    }
}
