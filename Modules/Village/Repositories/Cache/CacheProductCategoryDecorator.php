<?php namespace Modules\Village\Repositories\Cache;

use Modules\Village\Repositories\ProductCategoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProductCategoryDecorator extends BaseCacheDecorator implements ProductCategoryRepository
{
    public function __construct(ProductCategoryRepository $productcategory)
    {
        parent::__construct();
        $this->entityName = 'village.productcategories';
        $this->repository = $productcategory;
    }
}
