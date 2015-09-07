<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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


        Schema::create('village__users', function(Blueprint $table) 
        {
            $table->increments('id');

            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->unique();
            $table->string('password');
            $table->boolean('activated')->default(false);

            $table->integer('building_id')->unsigned();
            $table->foreign('building_id')->references('id')->on('village__buildings');

            $table->timestamps();
        });


        Schema::create('village__tokens', function(Blueprint $table) 
        {
            $table->increments('id');
            
            $table->string('code')->unique();
            $table->string('phone');
            $table->enum('type', ['RESTORE', 'RESET', 'CREATE']);

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


        Schema::create('village__servicecategories', function(Blueprint $table) 
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

            $table->integer('service_category_id')->unsigned();
            $table->foreign('service_category_id')->references('id')->on('village__servicecategories');

            $table->string('title')->unique();
            $table->decimal('price', 10, 2);
            $table->boolean('active')->default(true);

            $table->timestamps();
        });


        Schema::create('village__serviceorders', function(Blueprint $table) 
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


        Schema::create('village__productcategories', function(Blueprint $table) 
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

            $table->integer('product_category_id')->unsigned();
            $table->foreign('product_category_id')->references('id')->on('village__productcategories');

            $table->string('title')->unique();
            $table->decimal('price', 10, 2);
            $table->string('unit_title')->default('kg');
            $table->string('image');
            $table->boolean('active')->default(true);

            $table->timestamps();
        });


        Schema::create('village__productorders', function(Blueprint $table) 
        {
            $table->increments('id');

            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('village__products');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('village__users');

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


        Schema::create('village__surveyvotes', function(Blueprint $table) 
        {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('village__users');
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
            $table->enum('type', ['PERCENT', 'CASH']);
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
        
        Schema::drop('village__surveyvotes');
        Schema::drop('village__surveys');
        
        Schema::drop('village__productorders');
        Schema::drop('village__products');
        Schema::drop('village__productcategories');
        
        Schema::drop('village__serviceorders');
        Schema::drop('village__services');
        Schema::drop('village__servicecategories');

        Schema::drop('village__articles');
        Schema::drop('village__tokens');
        Schema::drop('village__users');
        Schema::drop('village__buildings');
    }
}
