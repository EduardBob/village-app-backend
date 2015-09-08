<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Modules\Village\Entities\Margin;
use Modules\Village\Entities\Token;

use Modules\Village\Entities\VillageUser;

class CreateVillageMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('village__buildings', function(Blueprint $table) 
        {
            $table->increments('id');

            $table->string('address')->unique();
            $table->string('code')->unique();

            $table->timestamps();
        });


        Schema::table('users', function ($table) {            
            $table->boolean('activated')->default(false)->after('last_name');
            $table->string('phone')->unique()->after('last_name');

            $table->integer('building_id')->nullable()->unsigned()->after('last_name');
            $table->foreign('building_id')->references('id')->on('village__buildings');
        });


        Schema::create('village__tokens', function(Blueprint $table) 
        {
            $table->increments('id');
            
            $table->string('code')->unique();
            $table->string('phone');
            $table->enum('type', (new Token)->getTypes());

            $table->timestamps();
        });


        Schema::create('village__articles', function(Blueprint $table) 
        {
            $table->increments('id');
            
            $table->string('title');
            $table->text('text');
            $table->text('short');

            $table->timestamps();
        });


        Schema::create('village__service_categories', function(Blueprint $table) 
        {
            $table->increments('id');
            
            $table->string('title')->unique();
            $table->integer('parent_id')->default(0);
            $table->integer('order');
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

            $table->timestamps();
        });


        Schema::create('village__service_orders', function(Blueprint $table) 
        {
            $table->increments('id');

            $table->integer('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('village__services');

            $table->dateTime('dateTime');
            $table->decimal('price', 10, 2);
            $table->text('comment')->nullable();
            $table->enum('status', ['PROCESSED', 'IN PROGRESS', 'DONE', 'REJECTED']);
            $table->text('decllineReason')->nullable();

            $table->timestamps();
        });


        Schema::create('village__product_categories', function(Blueprint $table) 
        {
            $table->increments('id');

            $table->string('title')->unique();
            $table->integer('order');
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

            $table->timestamps();
        });


        Schema::create('village__product_orders', function(Blueprint $table) 
        {
            $table->increments('id');

            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('village__products');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->dateTime('dateTime');
            $table->decimal('price', 10, 2);
            $table->string('unit_title')->default('kg');
            $table->decimal('quantity', 5, 2);
            $table->text('comment');
            $table->enum('status', ['PROCESSED', 'IN PROGRESS', 'DONE', 'REJECTED']);

            $table->timestamps();
        });


        Schema::create('village__surveys', function(Blueprint $table) 
        {
            $table->increments('id');

            $table->string('title');
            $table->json('options');
            $table->dateTime('endsAt');

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


        Schema::create('village__options', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('key');
            $table->text('value');

            $table->timestamps();
        });


        Schema::create('village__margins', function(Blueprint $table)
        {
            $table->increments('id');

            $table->boolean('is_removable')->default(true);
            $table->enum('type', (new Margin)->getTypes());
            $table->decimal('value', 3, 2);
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
        Schema::drop('village__options');
        
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

        VillageUser::where('activated', 1)->delete();
        Schema::table('users', function ($table) {
            $table->dropForeign(['building_id']);
            $table->dropColumn(['activated', 'phone', 'building_id']);
        });

        Schema::drop('village__buildings');
    }
}
