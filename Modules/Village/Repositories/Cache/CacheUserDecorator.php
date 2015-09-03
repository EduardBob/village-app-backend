<?php namespace Modules\Village\Repositories\Cache;

use Modules\Village\Repositories\UserRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheUserDecorator extends BaseCacheDecorator implements UserRepository
{
    public function __construct(UserRepository $user)
    {
        parent::__construct();
        $this->entityName = 'village.users';
        $this->repository = $user;
    }
}
