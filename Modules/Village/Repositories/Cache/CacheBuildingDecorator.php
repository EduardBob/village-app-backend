<?php namespace Modules\Village\Repositories\Cache;

use Modules\Village\Repositories\BuildingRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheBuildingDecorator extends BaseCacheDecorator implements BuildingRepository
{
    public function __construct(BuildingRepository $building)
    {
        parent::__construct();
        $this->entityName = 'village.buildings';
        $this->repository = $building;
    }
}
