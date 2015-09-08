<?php namespace Modules\Village\Repositories\Cache;

use Modules\Village\Repositories\SurveyRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheSurveyDecorator extends BaseCacheDecorator implements SurveyRepository
{
    public function __construct(SurveyRepository $survey)
    {
        parent::__construct();
        $this->entityName = 'village.surveys';
        $this->repository = $survey;
    }
}
