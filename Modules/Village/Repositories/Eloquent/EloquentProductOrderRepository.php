<?php namespace Modules\Village\Repositories\Eloquent;

use Modules\Village\Entities\User;
use Modules\Village\Entities\Village;
use Modules\Village\Repositories\ProductOrderRepository;

class EloquentProductOrderRepository extends VillageBaseRepository implements ProductOrderRepository
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
            ->leftJoin('village__products', 'village__product_orders.product_id', '=', 'village__products.id')
            ->where('village__product_orders.status', 'processing')
        ;

        if ($village) {
            $query->where('village__product_orders.village_id', $village->id);
        }
        if ($executor) {
            $query->where('village__products.executor_id', $executor->id);
        }

        return $query->count();
    }
}
