<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVillageServiceExecutorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('village__service_executors', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('village__services')->onDelete('CASCADE');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');

            $table->unique(['service_id', 'user_id']);
        });

        DB::transaction(function () {
            $services = \Modules\Village\Entities\Service::all();

            foreach ($services as $service) {
                if (!$service->executor) continue;

                $serviceExecutor = new \Modules\Village\Entities\ServiceExecutor();
                $serviceExecutor->service()->associate($service);
                $serviceExecutor->user()->associate($service->executor);
                $serviceExecutor->save();
            }
        });

        Schema::table('village__services', function (Blueprint $table) {
            $table->dropForeign('village__services_executor_id_foreign');
            $table->dropColumn('executor_id');
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
            $table->integer('executor_id')->unsigned()->nullable();
            $table->foreign('executor_id')->references('id')->on('users')->onDelete('SET NULL');;
        });

        DB::transaction(function () {
            $serviceExecutors = \Modules\Village\Entities\ServiceExecutor::all();

            foreach ($serviceExecutors as $serviceExecutor) {
                $service = $serviceExecutor->service;
                $service->executor()->associate($serviceExecutor->user);
                $service->save();
            }
        });

        Schema::table('village__service_executors', function (Blueprint $table) {
            $table->dropForeign('village__service_executors_service_id_foreign');
            $table->dropForeign('village__service_executors_user_id_foreign');
            $table->dropUnique('village__service_executors_service_id_user_id_unique');
        });

        Schema::drop('village__service_executors');
    }
}
