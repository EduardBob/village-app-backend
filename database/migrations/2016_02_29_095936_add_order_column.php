<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('village__products', function (Blueprint $table) {
            $table->integer('order')->default(0);
            $table->index('order');
        });

        Schema::table('village__services', function (Blueprint $table) {
            $table->integer('order')->default(0);
            $table->index('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('village__products', function (Blueprint $table) {
            $table->dropIndex('village__products_order_index');
            $table->dropColumn('order');
        });

        Schema::table('village__services', function (Blueprint $table) {
            $table->dropIndex('village__services_order_index');
            $table->dropColumn('order');
        });
    }
}
