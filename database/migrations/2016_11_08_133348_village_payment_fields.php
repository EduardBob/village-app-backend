<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VillagePaymentFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('village__villages', function (Blueprint $table) {
            $table->timestamp('payed_until');
            $table->smallInteger('packet')->default(1);
            $table->integer('balance')->default(0);
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
            $table->dropIfExists('payed_until');
            $table->dropIfExists('packet');
            $table->dropIfExists('balance');
        });

    }
}
