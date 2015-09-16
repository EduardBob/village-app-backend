<?php namespace Modules\Village\Repositories\Cache;

use Modules\Village\Repositories\ProfileRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProfileDecorator extends BaseCacheDecorator implements ProfileRepository
{
    public function __construct(ProfileRepository $profile)
    {
        parent::__construct();
        $this->entityName = 'village.profiles';
        $this->repository = $profile;
    }
}
