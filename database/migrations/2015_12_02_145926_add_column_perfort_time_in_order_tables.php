<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPerfortTimeInOrderTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('village__base__services', function (Blueprint $table) {
            DB::statement("ALTER TABLE `village__base__services` CHANGE `show_perform_at` `show_perform_time` TINYINT(1) NOT NULL DEFAULT '0';");
        });

        Schema::table('village__services', function (Blueprint $table) {
            DB::statement("ALTER TABLE `village__services` CHANGE `show_perform_at` `show_perform_time` TINYINT(1) NOT NULL DEFAULT '0';");
        });

        Schema::table('village__base__products', function (Blueprint $table) {
            DB::statement("ALTER TABLE `village__base__products` CHANGE `show_perform_at` `show_perform_time` TINYINT(1) NOT NULL DEFAULT '0';");
        });

        Schema::table('village__products', function (Blueprint $table) {
            DB::statement("ALTER TABLE `village__products` CHANGE `show_perform_at` `show_perform_time` TINYINT(1) NOT NULL DEFAULT '0';");
        });

        Schema::table('village__service_orders', function (Blueprint $table) {
            DB::statement("ALTER TABLE `village__service_orders` CHANGE `perform_at` `perform_date` DATE NOT NULL;");
            $table->time('perform_time')->nullable();
        });

        Schema::table('village__product_orders', function (Blueprint $table) {
            DB::statement("ALTER TABLE `village__product_orders` CHANGE `perform_at` `perform_date` DATE NOT NULL;");
            $table->time('perform_time')->nullable();
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
            DB::statement("ALTER TABLE `village__base__services` CHANGE `show_perform_time` `show_perform_at` TINYINT(1) NOT NULL DEFAULT '0';");
        });

        Schema::table('village__services', function (Blueprint $table) {
            DB::statement("ALTER TABLE `village__services` CHANGE `show_perform_time` `show_perform_at` TINYINT(1) NOT NULL DEFAULT '0';");
        });

        Schema::table('village__base__products', function (Blueprint $table) {
            DB::statement("ALTER TABLE `village__base__products` CHANGE `show_perform_time` `show_perform_at` TINYINT(1) NOT NULL DEFAULT '0';");
        });

        Schema::table('village__products', function (Blueprint $table) {
            DB::statement("ALTER TABLE `village__products` CHANGE `show_perform_time` `show_perform_at` TINYINT(1) NOT NULL DEFAULT '0';");
        });

        Schema::table('village__service_orders', function (Blueprint $table) {
            DB::statement("ALTER TABLE `village__service_orders` CHANGE `perform_date` `perform_at` DATETIME NOT NULL;");
            $table->dropColumn('perform_time');
        });

        Schema::table('village__product_orders', function (Blueprint $table) {
            DB::statement("ALTER TABLE `village__product_orders` CHANGE `perform_date` `perform_at` DATETIME NOT NULL;");
            $table->dropColumn('perform_time');
        });
    }
}
