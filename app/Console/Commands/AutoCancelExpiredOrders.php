<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Modules\Village\Entities\OrderInterface;
use Modules\Village\Entities\ProductOrder;
use Modules\Village\Entities\ServiceOrder;

class AutoCancelExpiredOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:cancel-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel expired orders';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
	    $date = (new \DateTime())->modify('-20 minutes')->format('Y-m-d H:i:s');

	    $orders = ServiceOrder
		    ::where('transaction_id', '!=', '')
//		    ->where('transaction_id', 'IS NOT NULL')
		    ->where('status', OrderInterface::STATUS_PROCESSING)
		    ->where('payment_type', OrderInterface::PAYMENT_TYPE_CARD)
		    ->where('payment_status', OrderInterface::PAYMENT_STATUS_NOT_PAID)
		    ->where('created_at', '<=', $date)
		    ->get()
		;

	    if (count($orders)) {
		    /** @var Model $order */
		    foreach($orders as $order) {
			    $order->status = OrderInterface::STATUS_REJECTED;
			    $order->save();
		    }
	    }

	    $orders = ProductOrder
		    ::where('transaction_id', '!=', '')
//		    ->where('transaction_id', 'IS NOT NULL')
		    ->where('status', OrderInterface::STATUS_PROCESSING)
		    ->where('payment_type', OrderInterface::PAYMENT_TYPE_CARD)
		    ->where('payment_status', OrderInterface::PAYMENT_STATUS_NOT_PAID)
		    ->where('created_at', '<=', $date)
		    ->get()
	    ;

	    if (count($orders)) {
		    /** @var Model $order */
		    foreach($orders as $order) {
			    $order->status = OrderInterface::STATUS_REJECTED;
			    $order->save();
		    }
	    }

	    $this->info("Syncing good");
    }
}
