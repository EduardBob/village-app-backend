<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsersCanBeDeletable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        DB::statement("ALTER TABLE `village__villages` DROP FOREIGN KEY `village__villages_main_admin_id_foreign`;");
        DB::statement("ALTER TABLE `village__villages` ADD CONSTRAINT `village__villages_main_admin_id_foreign` FOREIGN KEY (`main_admin_id`) REFERENCES `users`(`id`) ON DELETE SET NULL ON UPDATE RESTRICT;");

        DB::statement("ALTER TABLE `village__product_orders` DROP FOREIGN KEY `village__product_orders_user_id_foreign`;");
        DB::statement("ALTER TABLE `village__product_orders` CHANGE `user_id` `user_id` INT(10) UNSIGNED NULL DEFAULT NULL;");
        DB::statement("ALTER TABLE `village__product_orders` ADD CONSTRAINT `village__product_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `village`.`users`(`id`) ON DELETE SET NULL ON UPDATE RESTRICT;");

        DB::statement("ALTER TABLE `village__service_orders` DROP FOREIGN KEY `village__service_orders_user_id_foreign`;");
        DB::statement("ALTER TABLE `village__service_orders` CHANGE `user_id` `user_id` INT(10) UNSIGNED NULL DEFAULT NULL;");
        DB::statement("ALTER TABLE `village__service_orders` ADD CONSTRAINT `village__service_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `village`.`users`(`id`) ON DELETE SET NULL ON UPDATE RESTRICT;");

        DB::statement("ALTER TABLE `village__survey_votes` DROP FOREIGN KEY `village__survey_votes_user_id_foreign`;");
        DB::statement("ALTER TABLE `village__survey_votes` CHANGE `user_id` `user_id` INT(10) UNSIGNED NULL DEFAULT NULL;");
        DB::statement("ALTER TABLE `village__survey_votes` ADD  CONSTRAINT `village__survey_votes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL ON UPDATE RESTRICT;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        DB::statement("ALTER TABLE `village__villages` DROP FOREIGN KEY `village__villages_main_admin_id_foreign`;");
        DB::statement("ALTER TABLE `village__villages` ADD CONSTRAINT `village__villages_main_admin_id_foreign` FOREIGN KEY (`main_admin_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;");

        DB::statement("ALTER TABLE `village__product_orders` DROP FOREIGN KEY `village__product_orders_user_id_foreign`;");
        DB::statement("ALTER TABLE `village__product_orders` CHANGE `user_id` `user_id` INT(10) UNSIGNED NOT NULL;");
        DB::statement("ALTER TABLE `village__product_orders` ADD CONSTRAINT `village__product_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `village`.`users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;");

        DB::statement("ALTER TABLE `village__service_orders` DROP FOREIGN KEY `village__service_orders_user_id_foreign`;");
        DB::statement("ALTER TABLE `village__service_orders` CHANGE `user_id` `user_id` INT(10) UNSIGNED NOT NULL;");
        DB::statement("ALTER TABLE `village__service_orders` ADD CONSTRAINT `village__service_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `village`.`users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;");

        DB::statement("ALTER TABLE `village__survey_votes` DROP FOREIGN KEY `village__survey_votes_user_id_foreign`;");
        DB::statement("ALTER TABLE `village__survey_votes` CHANGE `user_id` `user_id` INT(10) UNSIGNED NOT NULL;");
        DB::statement("ALTER TABLE `village__survey_votes` ADD  CONSTRAINT `village__survey_votes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;");
    }
}
