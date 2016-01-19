<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeletedAtVillageProductsAndServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('village__product_categories', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('village__products', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('village__service_categories', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('village__services', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('village__villages', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('village__surveys', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('village__product_categories', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('village__products', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('village__service_categories', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('village__services', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('village__villages', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('village__surveys', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
}
