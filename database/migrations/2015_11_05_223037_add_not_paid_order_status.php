<?php

use Illuminate\Database\Migrations\Migration;

class AddNotPaidOrderStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $statuses = "'" . implode("','", config('village.order.statuses')) . "'";

        DB::statement("ALTER TABLE village__product_orders CHANGE COLUMN status status ENUM({$statuses}) NOT NULL DEFAULT 'not_paid'");
        DB::statement("ALTER TABLE village__product_order_changes CHANGE COLUMN from_status from_status ENUM({$statuses}) DEFAULT NULL");
        DB::statement("ALTER TABLE village__product_order_changes CHANGE COLUMN to_status to_status ENUM({$statuses}) NOT NULL DEFAULT 'not_paid'");

        DB::statement("ALTER TABLE village__service_orders CHANGE COLUMN status status ENUM({$statuses}) NOT NULL DEFAULT 'not_paid'");
        DB::statement("ALTER TABLE village__service_order_changes CHANGE COLUMN from_status from_status ENUM({$statuses}) DEFAULT NULL");
        DB::statement("ALTER TABLE village__service_order_changes CHANGE COLUMN to_status to_status ENUM({$statuses}) NOT NULL DEFAULT 'not_paid'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->up();
    }
}
