<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVillageServiceCategoryTranslationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('village__servicecategory_translations', function(Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('servicecategory_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['servicecategory_id', 'locale']);
            $table->foreign('servicecategory_id')->references('id')->on('village__servicecategories')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('village__servicecategory_translations');
	}
}
