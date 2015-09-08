<?php namespace Modules\Village\Repositories\Cache;

use Modules\Village\Repositories\TokenRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheTokenDecorator extends BaseCacheDecorator implements TokenRepository
{
    public function __construct(TokenRepository $token)
    {
        parent::__construct();
        $this->entityName = 'village.tokens';
        $this->repository = $token;
    }
}
