<?php namespace Modules\Village\Repositories\Cache;

use Modules\Village\Repositories\ServiceOrderRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheServiceOrderDecorator extends BaseCacheDecorator implements ServiceOrderRepository
{
    public function __construct(ServiceOrderRepository $serviceorder)
    {
        parent::__construct();
        $this->entityName = 'village.serviceorders';
        $this->repository = $serviceorder;
    }
}
