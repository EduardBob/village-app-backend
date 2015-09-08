<?php namespace Modules\Village\Repositories\Cache;

use Modules\Village\Repositories\OptionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheOptionDecorator extends BaseCacheDecorator implements OptionRepository
{
    public function __construct(OptionRepository $option)
    {
        parent::__construct();
        $this->entityName = 'village.options';
        $this->repository = $option;
    }
}
