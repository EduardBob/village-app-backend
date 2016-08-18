<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContactPhoneToVillageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('village__villages', function (Blueprint $table) {
            $table->text('important_contacts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('village__villages', function (Blueprint $table) {
            $table->dropColumn('important_contacts');
        });
    }
}
