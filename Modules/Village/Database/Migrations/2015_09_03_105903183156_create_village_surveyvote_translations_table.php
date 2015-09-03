<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVillageSurveyVoteTranslationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('village__surveyvote_translations', function(Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('surveyvote_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['surveyvote_id', 'locale']);
            $table->foreign('surveyvote_id')->references('id')->on('village__surveyvotes')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('village__surveyvote_translations');
	}
}
