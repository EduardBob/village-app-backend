<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVillageServiceTranslationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('village__service_translations', function(Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('service_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['service_id', 'locale']);
            $table->foreign('service_id')->references('id')->on('village__services')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('village__service_translations');
	}
}
