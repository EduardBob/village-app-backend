<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLinkColumnInBuildingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('village__buildings', function (Blueprint $table) {
            $table->string('link');
        });

        try {
            // случайно добавленное поле, обратно не возвращаем
            Schema::table('village__villages', function (Blueprint $table) {
                $table->dropColumn('link');
            });
        }
        catch (\Exception $e) {}

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('village__buildings', function (Blueprint $table) {
            $table->dropColumn('link');
        });
    }
}
