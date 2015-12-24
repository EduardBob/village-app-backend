<?php namespace Modules\Village\Repositories\Eloquent;

use Modules\Village\Entities\User;
use Modules\Village\Entities\Village;
use Modules\Village\Repositories\ServiceOrderRepository;

class EloquentServiceOrderRepository extends VillageBaseRepository implements ServiceOrderRepository
{
    /**
     * @param Village $village
     * @param User    $executor
     *
     * @return integer
     */
    public function count(Village $village = null, User $executor = null)
    {
        $query = $this
            ->model
            ->leftJoin('village__services', 'village__service_orders.service_id', '=', 'village__services.id')
            ->where('village__service_orders.status', 'processing')
        ;

        if ($village) {
            $query->where('village__service_orders.village_id', $village->id);
        }
        if ($executor) {
            $query
                ->leftJoin('village__service_executors', 'village__service_executors.service_id', '=', 'village__services.id')
                ->where('village__service_executors.user_id', $executor->id)
            ;
        }

        return $query->count();
    }
}
