<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVillageProductOrderTranslationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('village__productorder_translations', function(Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('productorder_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['productorder_id', 'locale']);
            $table->foreign('productorder_id')->references('id')->on('village__productorders')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('village__productorder_translations');
	}
}
