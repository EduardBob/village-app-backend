<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnShowPerformAtInServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('village__base__services', function (Blueprint $table) {
            $table->boolean('show_perform_at')->default(false);
        });

        Schema::table('village__services', function (Blueprint $table) {
            $table->boolean('show_perform_at')->default(false);
        });

        Schema::table('village__base__products', function (Blueprint $table) {
            $table->boolean('show_perform_at')->default(false);
        });

        Schema::table('village__products', function (Blueprint $table) {
            $table->boolean('show_perform_at')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('village__base__services', function (Blueprint $table) {
            $table->dropColumn('show_perform_at');
        });

        Schema::table('village__services', function (Blueprint $table) {
            $table->dropColumn('show_perform_at');
        });

        Schema::table('village__base__products', function (Blueprint $table) {
            $table->dropColumn('show_perform_at');
        });

        Schema::table('village__products', function (Blueprint $table) {
            $table->dropColumn('show_perform_at');
        });
    }
}
