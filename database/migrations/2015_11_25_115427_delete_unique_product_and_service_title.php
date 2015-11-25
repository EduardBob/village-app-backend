<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteUniqueProductAndServiceTitle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::table('village__products', function (Blueprint $table) {
            $table->dropUnique('village__products_village_id_title_unique');
        });
        Schema::table('village__product_categories', function (Blueprint $table) {
            $table->dropUnique('village__product_categories_village_id_title_unique');
        });

        Schema::table('village__services', function (Blueprint $table) {
            $table->dropUnique('village__services_village_id_title_unique');
        });
        Schema::table('village__service_categories', function (Blueprint $table) {
            $table->dropUnique('village__service_categories_village_id_title_unique');
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('village__products', function (Blueprint $table) {
                $table->dropUnique('village__products_title_unique');
                $table->unique(['village_id', 'title']);
            });
        Schema::table('village__product_categories', function (Blueprint $table) {
                $table->dropUnique('village__product_categories_title_unique');
                $table->unique(['village_id', 'title']);
            });

        Schema::table('village__services', function (Blueprint $table) {
                $table->dropUnique('village__services_title_unique');
                $table->unique(['village_id', 'title']);
            });
        Schema::table('village__service_categories', function (Blueprint $table) {
                $table->dropUnique('village__service_categories_title_unique');
                $table->unique(['village_id', 'title']);
            });

        Schema::table('village__survey_votes', function (Blueprint $table) {
                $table->unique(['survey_id', 'user_id']);
            });
    }
}
