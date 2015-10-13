<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Modules\Village\Entities\Margin;
use Modules\Village\Entities\Token;

class CreateVillageMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('village__buildings')) {
            Schema::create('village__buildings', function(Blueprint $table)
            {
                $table->increments('id');

                $table->string('address')->unique();
                $table->string('code')->unique();

                $table->timestamps();
            });
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function(Blueprint $table) {
                if (Schema::hasColumn('users', 'email')) {
                    $table->dropUnique('users_email_unique');
                    $table->dropColumn('email');
                }
                if (!Schema::hasColumn('users', 'phone')) {
                    $table->string('phone', 25)->unique();
                }

                if (!Schema::hasColumn('users', 'building_id')) {
                    $table->integer('building_id')->nullable()->unsigned();
                    $table->foreign('building_id')->references('id')->on('village__buildings')->onDelete('SET NULL');
                }
            });
        }

        Schema::create('village__tokens', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('code')->unique();
            $table->string('session', config('village.token.session.length'));
            $table->string('phone', 25);
            $table->string('new_phone', 25)->nullable();
            $table->enum('type', (new Token)->getTypes());

            $table->timestamps();
        });


        Schema::create('village__articles', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('title');
            $table->text('text');
            $table->text('short');
            $table->boolean('active')->default(true);

            $table->timestamps();
        });


        Schema::create('village__service_categories', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('title')->unique();
            $table->integer('parent_id')->default(0);
            $table->integer('order')->default(0);
            $table->boolean('active')->default(true);

            $table->timestamps();
        });


        Schema::create('village__services', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('village__service_categories');

            $table->string('title')->unique();
            $table->decimal('price', 10, 2);
            $table->boolean('active')->default(true);
            $table->string('text');
            $table->string('comment_label', 50);
            $table->string('order_button_label', 50);

            $table->timestamps();
        });


        Schema::create('village__service_orders', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('village__services');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->dateTime('perform_at');
            $table->decimal('price', 10, 2);
            $table->text('comment')->nullable();
            $table->enum('status', config('village.order.statuses'))->default(config('village.order.statuses')[0]);
            $table->text('decline_reason')->nullable();

            $table->timestamps();
        });


        Schema::create('village__product_categories', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('title')->unique();
            $table->integer('order')->default(0);
            $table->boolean('active')->default(true);

            $table->timestamps();
        });


        Schema::create('village__products', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('village__product_categories');

            $table->string('title')->unique();
            $table->decimal('price', 10, 2);
            $table->string('unit_title')->default('kg');
            $table->string('image');
            $table->boolean('active')->default(true);
            $table->string('comment_label', 50);
            $table->string('text');

            $table->timestamps();
        });


        Schema::create('village__product_orders', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('village__products');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->dateTime('perform_at');
            $table->decimal('price', 10, 2);
            $table->string('unit_title')->default('kg');
            $table->decimal('quantity', 5, 2);
            $table->text('comment');
            $table->text('decline_reason')->nullable();
            $table->enum('status', config('village.order.statuses'));

            $table->timestamps();
        });

        Schema::create('village__surveys', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('title');
            $table->json('options');
            $table->dateTime('ends_at');
            $table->boolean('active')->default(true);

            $table->timestamps();
        });


        Schema::create('village__survey_votes', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('survey_id')->unsigned();
            $table->foreign('survey_id')->references('id')->on('village__surveys');

            $table->integer('choice');

            $table->timestamps();
        });


        Schema::create('village__margins', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('title');
            $table->boolean('is_removable')->default(true);
            $table->boolean('is_primary')->default(false);
            $table->enum('type', (new Margin)->getTypes());
            $table->decimal('value', 5, 2);
            $table->integer('order')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('village__margins');

        Schema::drop('village__survey_votes');
        Schema::drop('village__surveys');

        Schema::drop('village__product_orders');
        Schema::drop('village__products');
        Schema::drop('village__product_categories');

        Schema::drop('village__service_orders');
        Schema::drop('village__services');
        Schema::drop('village__service_categories');

        Schema::drop('village__articles');
        Schema::drop('village__tokens');

        Schema::table('users', function(Blueprint $table) {
            if (Schema::hasColumn('users', 'building_id')) {
                $table->dropForeign('users_building_id_foreign');
                $table->dropColumn('building_id');
            }
        });

        Schema::drop('village__buildings');
    }
}
