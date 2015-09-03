<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVillageServiceOrderTranslationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('village__serviceorder_translations', function(Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('serviceorder_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['serviceorder_id', 'locale']);
            $table->foreign('serviceorder_id')->references('id')->on('village__serviceorders')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('village__serviceorder_translations');
	}
}
