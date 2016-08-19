<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeVillageIdAllowNullsInArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('village__articles', function (Blueprint $table) {
            DB::statement("ALTER TABLE `village`.`village__articles` CHANGE COLUMN `village_id` `village_id` int(10) UNSIGNED ZEROFILL;");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('village__articles', function (Blueprint $table) {
            DB::statement("ALTER TABLE `village`.`village__articles` CHANGE COLUMN `village_id` `village_id` int(10) UNSIGNED ZEROFILL NOT NULL;");
        });
    }
}
