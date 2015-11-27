<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBaseSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('village__base__surveys', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->json('options');
            $table->boolean('active')->default(false);

            $table->timestamps();
        });

        Schema::table('village__surveys', function (Blueprint $table) {
            $table->integer('base_id')->unsigned()->nullable()->unique();
            $table->foreign('base_id')->references('id')->on('village__base__surveys')->onDelete('SET NULL');
            DB::statement("ALTER TABLE `village__surveys` CHANGE `active` `active` TINYINT(1) NOT NULL DEFAULT '0';");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('village__surveys', function (Blueprint $table) {
            $table->dropForeign('village__surveys_base_id_foreign');
            $table->dropColumn('base_id');
        });

        Schema::drop('village__base__surveys');
    }
}
