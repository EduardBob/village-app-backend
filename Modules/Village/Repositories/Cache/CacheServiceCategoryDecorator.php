<?php namespace Modules\Village\Repositories\Cache;

use Modules\Village\Repositories\ServiceCategoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheServiceCategoryDecorator extends BaseCacheDecorator implements ServiceCategoryRepository
{
    public function __construct(ServiceCategoryRepository $servicecategory)
    {
        parent::__construct();
        $this->entityName = 'village.servicecategories';
        $this->repository = $servicecategory;
    }
}
