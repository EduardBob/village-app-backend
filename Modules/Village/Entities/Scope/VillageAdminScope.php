<?php

namespace Modules\Village\Entities\Scope;

use Modules\Village\Entities\User;

trait VillageAdminScope
{
    /**
     * Scope a query to only include active users.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVillageAdmin($query)
    {
        $auth = app('Modules\Core\Contracts\Authentication');
        /** @var User $user */
        $user = $auth->check();

        return $query->where('village_id', $user->village->id);
    }
}