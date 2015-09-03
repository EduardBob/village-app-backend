<?php namespace Modules\Village\Repositories\Cache;

use Modules\Village\Repositories\ProductOrderRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProductOrderDecorator extends BaseCacheDecorator implements ProductOrderRepository
{
    public function __construct(ProductOrderRepository $productorder)
    {
        parent::__construct();
        $this->entityName = 'village.productorders';
        $this->repository = $productorder;
    }
}
