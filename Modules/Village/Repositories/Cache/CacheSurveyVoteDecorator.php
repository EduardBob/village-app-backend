<?php namespace Modules\Village\Repositories\Cache;

use Modules\Village\Repositories\SurveyVoteRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheSurveyVoteDecorator extends BaseCacheDecorator implements SurveyVoteRepository
{
    public function __construct(SurveyVoteRepository $surveyvote)
    {
        parent::__construct();
        $this->entityName = 'village.surveyvotes';
        $this->repository = $surveyvote;
    }
}
