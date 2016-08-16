<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeScheduledAtColumnInSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('village__sms', function (Blueprint $table) {
	        DB::statement("ALTER TABLE `village__sms` CHANGE `scheduled_at` `scheduled_at` DATETIME NULL;");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('village__sms', function (Blueprint $table) {
	        DB::statement("ALTER TABLE `village__sms` CHANGE `scheduled_at` `scheduled_at` DATETIME NOT NULL;");
        });
    }
}
