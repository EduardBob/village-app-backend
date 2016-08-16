<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSizeOfValueColumnMarginTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('village__margins', function (Blueprint $table) {
	        DB::statement("ALTER TABLE `village__margins` CHANGE `value` `value` DECIMAL(9,2) NOT NULL;");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('village__margins', function (Blueprint $table) {
	        DB::statement("ALTER TABLE `village__margins` CHANGE `value` `value` DECIMAL(5,2) NOT NULL;");
        });
    }
}
