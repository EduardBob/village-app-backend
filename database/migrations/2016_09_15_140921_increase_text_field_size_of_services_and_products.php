<?php

use Illuminate\Database\Migrations\Migration;

class IncreaseTextFieldSizeOfServicesAndProducts extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `village__products` MODIFY COLUMN `text` VARCHAR(765)');
        DB::statement('ALTER TABLE `village__base__products` MODIFY COLUMN `text` VARCHAR(765)');
        DB::statement('ALTER TABLE `village__base__services` MODIFY COLUMN `text` VARCHAR(765)');
        DB::statement('ALTER TABLE `village__services` MODIFY COLUMN `text` VARCHAR(765)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `village__products` MODIFY COLUMN `text` VARCHAR(255)');
        DB::statement('ALTER TABLE `village__base__products` MODIFY COLUMN `text` VARCHAR(255)');
        DB::statement('ALTER TABLE `village__base__services` MODIFY COLUMN `text` VARCHAR(255)');
        DB::statement('ALTER TABLE `village__services` MODIFY COLUMN `text` VARCHAR(255)');
    }
}
