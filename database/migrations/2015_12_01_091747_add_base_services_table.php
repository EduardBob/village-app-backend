<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBaseServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('village__base__services', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('village__service_categories');

            $table->string('title');
            $table->decimal('price', 10, 2);
            $table->boolean('active')->default(false);
            $table->string('comment_label', 50);
            $table->string('order_button_label', 50);
            $table->string('text');

            $table->timestamps();
        });

        Schema::table('village__services', function (Blueprint $table) {
            $table->integer('base_id')->unsigned()->nullable();
            $table->foreign('base_id')->references('id')->on('village__base__services')->onDelete('CASCADE');
            DB::statement("ALTER TABLE `village__services` CHANGE `active` `active` TINYINT(1) NOT NULL DEFAULT '0';");
            DB::statement("ALTER TABLE `village__services` CHANGE `title` `title` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;");
            DB::statement("ALTER TABLE `village__services` CHANGE `text` `text` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;");
            DB::statement("ALTER TABLE `village__services` CHANGE `comment_label` `comment_label` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;");
            DB::statement("ALTER TABLE `village__services` CHANGE `order_button_label` `order_button_label` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;");
            $table->unique(['base_id', 'village_id']);
        });

        Schema::table('village__service_categories', function (Blueprint $table) {
            $table->dropForeign('village__service_categories_village_id_foreign');
            $table->dropColumn('village_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('village__services', function (Blueprint $table) {
            $table->dropForeign('village__services_base_id_foreign');
            $table->dropUnique('village__services_base_id_village_id_unique');
            $table->dropColumn('base_id');
        });

        Schema::drop('village__base__services');

        Schema::table('village__service_categories', function (Blueprint $table) {
            $table->integer('village_id')->unsigned()->nullable();
            $table->foreign('village_id')->references('id')->on('village__villages');
        });
    }
}
