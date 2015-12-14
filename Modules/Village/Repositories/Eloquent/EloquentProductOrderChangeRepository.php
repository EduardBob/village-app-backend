<?php namespace Modules\Village\Repositories\Eloquent;

use Modules\Village\Entities\User;
use Modules\Village\Entities\Village;
use Modules\Village\Repositories\ProductOrderChangeRepository;

class EloquentProductOrderChangeRepository extends VillageBaseRepository implements ProductOrderChangeRepository
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
            ->select('village__product_order_changes.*')
            ->leftJoin('village__product_orders', 'village__product_order_changes.order_id', '=', 'village__product_orders.id')
            ->leftJoin('village__products', 'village__product_orders.product_id', '=', 'village__products.id')
            ->leftJoin('village__villages', 'village__products.village_id', '=', 'village__villages.id')
        ;

        if ($village) {
            $query->where('village__villages.id', $village->id);
        }
        if ($executor) {
            $query->where('village__product_order_changes.user_id', $executor->id);
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
            ->select('village__product_order_changes.*')
            ->leftJoin('village__product_orders', 'village__product_order_changes.order_id', '=', 'village__product_orders.id')
            ->leftJoin('village__products', 'village__product_orders.product_id', '=', 'village__products.id')
            ->leftJoin('village__villages', 'village__products.village_id', '=', 'village__villages.id')
        ;

        if ($village) {
            $query->where('village__villages.id', $village->id);
        }
        if ($executor) {
            $query->where('village__products.executor_id', $executor->id);
        }

        return $query
            ->orderBy('id', 'DESC')
            ->paginate($count)
        ;
    }
}
