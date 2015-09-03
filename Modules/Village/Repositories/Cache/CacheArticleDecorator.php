<?php namespace Modules\Village\Repositories\Cache;

use Modules\Village\Repositories\ArticleRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheArticleDecorator extends BaseCacheDecorator implements ArticleRepository
{
    public function __construct(ArticleRepository $article)
    {
        parent::__construct();
        $this->entityName = 'village.articles';
        $this->repository = $article;
    }
}
