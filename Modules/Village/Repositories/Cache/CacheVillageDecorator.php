<?php namespace Modules\Village\Repositories\Cache;

use Modules\Village\Repositories\VillageRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheVillageDecorator extends BaseCacheDecorator implements VillageRepository
{
    public function __construct(VillageRepository $village)
    {
        parent::__construct();
        $this->entityName = 'village.villages';
        $this->repository = $village;
    }
}
