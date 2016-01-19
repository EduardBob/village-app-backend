<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVillageSass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('village__villages', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('name', 50)->unique();
            $table->string('shop_name', 50);
            $table->string('shop_address', 100);
            $table->string('service_payment_info');
            $table->string('service_bottom_text');
            $table->string('product_payment_info');
            $table->string('product_bottom_text');
            $table->decimal('product_unit_step_kg', 2, 1)->default(0.5);
            $table->integer('product_unit_step_bottle')->default(1);
            $table->integer('product_unit_step_piece')->default(1);
            $table->boolean('active')->default(false);
            $table->timestamps();
        });
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->integer('village_id')->unsigned()->nullable();
                $table->foreign('village_id')->references('id')->on('village__villages');
            });
        }
        if (Schema::hasTable('village__articles')) {
            Schema::table('village__articles', function (Blueprint $table) {
                $table->integer('village_id')->unsigned();
                $table->foreign('village_id')->references('id')->on('village__villages');
            });
        }
        if (Schema::hasTable('village__buildings')) {
            Schema::table('village__buildings', function (Blueprint $table) {
                $table->integer('village_id')->unsigned();
                $table->foreign('village_id')->references('id')->on('village__villages');
            });
        }
        if (Schema::hasTable('village__service_categories')) {
            Schema::table('village__service_categories', function (Blueprint $table) {
                $table->integer('village_id')->unsigned();
                $table->foreign('village_id')->references('id')->on('village__villages');
            });
        }
        if (Schema::hasTable('village__services')) {
            Schema::table('village__services', function (Blueprint $table) {
                $table->integer('village_id')->unsigned();
                $table->foreign('village_id')->references('id')->on('village__villages');
            });
        }
        if (Schema::hasTable('village__service_orders')) {
            Schema::table('village__service_orders', function (Blueprint $table) {
                $table->integer('village_id')->unsigned();
                $table->foreign('village_id')->references('id')->on('village__villages');
            });
        }
        if (Schema::hasTable('village__product_categories')) {
            Schema::table('village__product_categories', function (Blueprint $table) {
                $table->integer('village_id')->unsigned();
                $table->foreign('village_id')->references('id')->on('village__villages');
            });
        }
        if (Schema::hasTable('village__products')) {
            Schema::table('village__products', function (Blueprint $table) {
                $table->integer('village_id')->unsigned();
                $table->foreign('village_id')->references('id')->on('village__villages');
            });
        }
        if (Schema::hasTable('village__product_orders')) {
            Schema::table('village__product_orders', function (Blueprint $table) {
                $table->integer('village_id')->unsigned();
                $table->foreign('village_id')->references('id')->on('village__villages');
            });
        }
        if (Schema::hasTable('village__surveys')) {
            Schema::table('village__surveys', function (Blueprint $table) {
                $table->integer('village_id')->unsigned();
                $table->foreign('village_id')->references('id')->on('village__villages');
            });
        }
        if (Schema::hasTable('village__survey_votes')) {
            Schema::table('village__survey_votes', function (Blueprint $table) {
                $table->integer('village_id')->unsigned();
                $table->foreign('village_id')->references('id')->on('village__villages');
            });
        }
        if (Schema::hasTable('village__margins')) {
            Schema::table('village__margins', function (Blueprint $table) {
                $table->integer('village_id')->unsigned();
                $table->foreign('village_id')->references('id')->on('village__villages');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            if (Schema::hasColumn('users', 'village_id')) {
                $table->dropForeign('users_village_id_foreign');
                $table->dropColumn('village_id');
            }
        });
        Schema::table('village__articles', function(Blueprint $table) {
            if (Schema::hasColumn('village__articles', 'village_id')) {
                $table->dropForeign('village__articles_village_id_foreign');
                $table->dropColumn('village_id');
            }
        });
        Schema::table('village__buildings', function(Blueprint $table) {
            if (Schema::hasColumn('village__buildings', 'village_id')) {
                $table->dropForeign('village__buildings_village_id_foreign');
                $table->dropColumn('village_id');
            }
        });
        Schema::table('village__service_categories', function(Blueprint $table) {
            if (Schema::hasColumn('village__service_categories', 'village_id')) {
                $table->dropForeign('village__service_categories_village_id_foreign');
                $table->dropColumn('village_id');
            }
        });
        Schema::table('village__services', function(Blueprint $table) {
            if (Schema::hasColumn('village__services', 'village_id')) {
                $table->dropForeign('village__services_village_id_foreign');
                $table->dropColumn('village_id');
            }
        });
        Schema::table('village__service_orders', function(Blueprint $table) {
            if (Schema::hasColumn('village__service_orders', 'village_id')) {
                $table->dropForeign('village__service_orders_village_id_foreign');
                $table->dropColumn('village_id');
            }
        });
        Schema::table('village__product_categories', function(Blueprint $table) {
            if (Schema::hasColumn('village__product_categories', 'village_id')) {
                $table->dropForeign('village__product_categories_village_id_foreign');
                $table->dropColumn('village_id');
            }
        });
        Schema::table('village__products', function(Blueprint $table) {
            if (Schema::hasColumn('village__products', 'village_id')) {
                $table->dropForeign('village__products_village_id_foreign');
                $table->dropColumn('village_id');
            }
        });
        Schema::table('village__product_orders', function(Blueprint $table) {
            if (Schema::hasColumn('village__product_orders', 'village_id')) {
                $table->dropForeign('village__product_orders_village_id_foreign');
                $table->dropColumn('village_id');
            }
        });
        Schema::table('village__surveys', function(Blueprint $table) {
            if (Schema::hasColumn('village__surveys', 'village_id')) {
                $table->dropForeign('village__surveys_village_id_foreign');
                $table->dropColumn('village_id');
            }
        });
        Schema::table('village__survey_votes', function (Blueprint $table) {
            if (Schema::hasColumn('village__survey_votes', 'village_id')) {
                $table->dropForeign('village__survey_votes_village_id_foreign');
                $table->dropColumn('village_id');
            }
        });
        Schema::table('village__margins', function(Blueprint $table) {
            if (Schema::hasColumn('village__margins', 'village_id')) {
                $table->dropForeign('village__margins_village_id_foreign');
                $table->dropColumn('village_id');
            }
        });

        Schema::drop('village__villages');
    }
}
