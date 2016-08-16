<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeColumnToServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('village__services', function (Blueprint $table) {
            $table->enum('type', ['default', 'sc'])->default('default');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('village__services', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
