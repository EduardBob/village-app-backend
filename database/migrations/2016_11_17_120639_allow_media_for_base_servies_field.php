<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AllowMediaForBaseServiesField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('village__base__services', function (Blueprint $table) {
            $table->boolean('allow_media')->default(0);
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
            $table->dropIfExists('allow_media');
        });
    }
}
