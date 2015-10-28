<?php namespace Modules\Village\Repositories;

use Modules\User\Repositories\RoleRepository;

interface UserRoleRepository extends RoleRepository
{
    /**
     * Find a role by its slug
     * @param  string $slug
     * @return mixed
     */
    public function findBySlug($slug);
}
