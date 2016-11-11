<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VillageIsUnlimitedField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('village__villages', function (Blueprint $table) {
            $table->boolean('is_unlimited')->default(0);
        });
        // All old facilities are unlimited
        DB::statement("UPDATE `village__villages` SET `is_unlimited` = 1");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('village__villages', function (Blueprint $table) {
            $table->dropIfExists('is_unlimited');
        });
    }
}
