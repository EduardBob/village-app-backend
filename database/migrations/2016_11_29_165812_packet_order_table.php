<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PacketOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('village__packet_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_id')->nullable(0);
            $table->integer('coins');
            $table->smallInteger('period');
            $table->smallInteger('packet');
            $table->dateTime('done_at')->nullable();
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('village_id')->unsigned()->index();
            $table->foreign('village_id')->references('id')->on('village__villages')->onDelete('cascade');
            $table->dateTime('perform_at');
            $table->decimal('price', 10, 2);
            $table
              ->enum('payment_status', config('village.order.payment.status.values'))
              ->default(config('village.order.payment.status.default'))
            ;
            $table->enum('status', config('village.order.statuses'))->default(config('village.order.statuses')[0]);
            $table->text('decline_reason')->nullable();
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
        Schema::dropIfExists('village__packet_orders');
    }
}
