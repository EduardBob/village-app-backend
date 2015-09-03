<?php namespace Modules\Village\Repositories\Cache;

use Modules\Village\Repositories\MarginRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheMarginDecorator extends BaseCacheDecorator implements MarginRepository
{
    public function __construct(MarginRepository $margin)
    {
        parent::__construct();
        $this->entityName = 'village.margins';
        $this->repository = $margin;
    }
}
