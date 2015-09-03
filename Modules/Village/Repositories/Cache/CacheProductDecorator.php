<?php namespace Modules\Village\Repositories\Cache;

use Modules\Village\Repositories\ProductRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProductDecorator extends BaseCacheDecorator implements ProductRepository
{
    public function __construct(ProductRepository $product)
    {
        parent::__construct();
        $this->entityName = 'village.products';
        $this->repository = $product;
    }
}
