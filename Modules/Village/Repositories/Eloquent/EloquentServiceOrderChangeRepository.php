<?php namespace Modules\Village\Repositories\Eloquent;

use Modules\Village\Entities\User;
use Modules\Village\Entities\Village;
use Modules\Village\Repositories\ServiceOrderChangeRepository;

class EloquentServiceOrderChangeRepository extends VillageBaseRepository implements ServiceOrderChangeRepository
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
            ->leftJoin('village__service_orders', 'village__service_order_changes.order_id', '=', 'village__service_orders.id')
            ->leftJoin('village__services', 'village__service_order_changes.service_id', '=', 'village__services.id')
            ->leftJoin('village__villages', 'village__services.village_id', '=', 'village__villages.id')
        ;

        if ($village) {
            $query->where('village__villages.id', $village->id);
        }
        if ($executor) {
            $query
                ->leftJoin('village__service_executors', 'village__service_executors.service_id', '=', 'village__services.id')
                ->where('village__service_executors.user_id', $executor->id)
            ;
        }

        return $query->count();
    }


    /**
     * @param int     $count
     * @param Village $village
     * @param User    $executor
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function latest($count, Village $village = null, User $executor = null)
    {
        $query = $this
            ->model
            ->select('village__service_order_changes.*')
            ->leftJoin('village__service_orders', 'village__service_order_changes.order_id', '=', 'village__service_orders.id')
            ->leftJoin('village__services', 'village__service_orders.service_id', '=', 'village__services.id')
            ->leftJoin('village__villages', 'village__services.village_id', '=', 'village__villages.id')
        ;

        if ($village) {
            $query->where('village__villages.id', $village->id);
        }
        if ($executor) {
            $query
                ->leftJoin('village__service_executors', 'village__service_executors.service_id', '=', 'village__services.id')
                ->where('village__service_executors.user_id', $executor->id)
            ;
        }

        return $query
            ->orderBy('id', 'DESC')
            ->paginate($count)
        ;
    }
}
