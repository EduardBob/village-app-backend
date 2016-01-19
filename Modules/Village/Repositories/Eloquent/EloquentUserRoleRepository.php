<?php namespace Modules\Village\Repositories\Eloquent;

use Modules\User\Repositories\Sentinel\SentinelRoleRepository;
use Modules\Village\Repositories\UserRoleRepository;

class EloquentUserRoleRepository extends SentinelRoleRepository implements UserRoleRepository
{
    /**
     * Find a role by its slug
     * @param  string $slug
     * @return mixed
     */
    public function findBySlug($slug)
    {
        return \Sentinel::findRoleBySlug($slug);
    }
}
