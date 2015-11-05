<?php namespace Modules\Village\Repositories\Cache;

use Modules\Village\Repositories\ProductOrderChangeRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProductOrderChangeDecorator extends BaseCacheDecorator implements ProductOrderChangeRepository
{
    public function __construct(ProductOrderChangeRepository $productOrderChange)
    {
        parent::__construct();
        $this->entityName = 'village.productOrderChanges';
        $this->repository = $productOrderChange;
    }
}
