<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBaseProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('village__base__products', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('village__product_categories');

            $table->string('title');
            $table->decimal('price', 10, 2);
            $table->enum('unit_title', config('village.product.unit.values'));
            $table->string('image');
            $table->boolean('active')->default(false);
            $table->string('comment_label', 50);
            $table->string('text');

            $table->timestamps();
        });

        Schema::table('village__products', function (Blueprint $table) {
            $table->integer('base_id')->unsigned()->nullable();
            $table->foreign('base_id')->references('id')->on('village__base__products')->onDelete('SET NULL');
            DB::statement("ALTER TABLE `village__products` CHANGE `active` `active` TINYINT(1) NOT NULL DEFAULT '0';");
        });

        Schema::table('village__product_categories', function (Blueprint $table) {
            $table->dropForeign('village__product_categories_village_id_foreign');
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
        Schema::table('village__products', function (Blueprint $table) {
            $table->dropForeign('village__products_base_id_foreign');
            $table->dropColumn('base_id');
        });

        Schema::drop('village__base__products');

        Schema::table('village__product_categories', function (Blueprint $table) {
            $table->integer('village_id')->unsigned()->nullable();
            $table->foreign('village_id')->references('id')->on('village__villages');
        });
    }
}
