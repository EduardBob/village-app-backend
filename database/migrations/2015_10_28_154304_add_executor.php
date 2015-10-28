<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExecutor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('village__services')) {
            Schema::table('village__services', function (Blueprint $table) {
                $table->integer('executor_id')->unsigned()->nullable();
                $table->foreign('executor_id')->references('id')->on('users')->onDelete('SET NULL');;
            });
        }
        if (Schema::hasTable('village__products')) {
            Schema::table('village__products', function (Blueprint $table) {
                $table->integer('executor_id')->unsigned()->nullable();
                $table->foreign('executor_id')->references('id')->on('users')->onDelete('SET NULL');;
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('village__services', function(Blueprint $table) {
            if (Schema::hasColumn('village__services', 'village_id')) {
                $table->dropForeign('village__services_executor_id_foreign');
                $table->dropColumn('executor_id');
            }
        });
        Schema::table('village__products', function(Blueprint $table) {
            if (Schema::hasColumn('village__products', 'village_id')) {
                $table->dropForeign('village__products_executor_id_foreign');
                $table->dropColumn('executor_id');
            }
        });
    }
}
