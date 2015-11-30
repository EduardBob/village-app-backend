<?php

namespace Modules\Village\Entities\Scope;

use Modules\Village\Entities\User;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

trait ApiScope
{
    /**
     * Scope a query to only include active users.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApi($query)
    {
        /** @var User $user */
        $user = \JWTAuth::parseToken()->authenticate();

        if (!$user) {
            throw new AccessDeniedHttpException();
        }

        $query->where($query->getModel()->table.'.active', 1);

        if (method_exists($query->getModel(), 'village')) {
            $query->where($query->getModel()->table.'.village_id', $user->village->id);
        }

        return $query;
    }
}