<?php namespace Modules\Village\Repositories\Cache;

use Modules\Village\Repositories\ServiceOrderChangeRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheServiceOrderChangeDecorator extends BaseCacheDecorator implements ServiceOrderChangeRepository
{
    public function __construct(ServiceOrderChangeRepository $serviceOrderChange)
    {
        parent::__construct();
        $this->entityName = 'village.serviceOrderChanges';
        $this->repository = $serviceOrderChange;
    }
}
