<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Village\Entities\Village;
use Illuminate\Support\Facades\Log;

class FacilityBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'facility:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the balance of facility, deactivates if needed or prolongs facility payment date.';

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
        $date       = (new Carbon())->format('Y-m-d H:i:00');
        $payedUntil = (new Carbon())->addMonth(1)->format('Y-m-d H:i:00');
        $expired    = Village
          ::where('payed_until', '<=', $date)
          ->where('is_unlimited', 0)
          ->get();

        if (count($expired)) {
            foreach ($expired as $facility) {
                $monthlyPayment = setting('village::village-' . $facility->type . '-' . $facility->packet . '-price');
                if ($monthlyPayment <= $facility->balance) {
                    $facility->balance     = $facility->balance - $monthlyPayment;
                    $facility->payed_until = $payedUntil;
                    $facility->active      = 1;
                    $facility->save();
                    $message = 'payed ' . $monthlyPayment . ' for ' .$facility->id.' '. $facility->name . ' balance left is ' . $facility->balance;
                    $this->info($message);
                    Log::info($message);
                } else if ($facility->active) {
                    $facility->active = 0;
                    $facility->save();
                    $message = 'facility ' . $facility->id.' '.$facility->name . ' has been deactivated';
                    $this->info($message);
                    Log::info($message);
                }
            }
        }
    }
}
