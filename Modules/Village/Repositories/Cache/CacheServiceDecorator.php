<?php namespace Modules\Village\Repositories\Cache;

use Modules\Village\Repositories\ServiceRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheServiceDecorator extends BaseCacheDecorator implements ServiceRepository
{
    public function __construct(ServiceRepository $service)
    {
        parent::__construct();
        $this->entityName = 'village.services';
        $this->repository = $service;
    }
}
