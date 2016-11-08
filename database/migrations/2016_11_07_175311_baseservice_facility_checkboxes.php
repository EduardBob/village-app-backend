<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Village\Entities\Village;


class BaseserviceFacilityCheckboxes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $types = Village::getTypes();
        Schema::table('village__base__services', function (Blueprint $table) use ($types) {
            foreach ($types as $type) {
                $table->boolean('is_' . $type)->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $types = Village::getTypes();
        Schema::table('village__base__services', function (Blueprint $table) use ($types) {
            foreach ($types as $type) {
                $table->dropIfExists('is_'.$type);
            }
        });
    }
}
