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
            ->leftJoin('village__services', 'village__service_order_changes.service_id', '=', 'village__services.id')
            ->leftJoin('village__villages', 'village__services.village_id', '=', 'village__villages.id')
        ;

        if ($village) {
            $query->where('village__villages.id', $village->id);
        }
        if ($executor) {
            $query->where('village__service_order_changes.user_id', $executor->id);
        }

        return $query->count();
    }
}
