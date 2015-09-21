<?php

namespace Modules\Village\Packback\Transformer;

use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use Modules\Village\Entities\SurveyVote;

class SurveyVoteTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['survey'];

    /**
     * List of resources to automatically include
     *
     * @var  array
     */
    protected $defaultIncludes = [];

    /**
     * Turn user object into generic array
     *
     * @param SurveyVote $surveyVote
     * @return array
     */
    public function transform(SurveyVote $surveyVote)
    {
        return [
            'choice' => $surveyVote->choice,
        ];
    }

    /**
     * Include survey in SurveyVote
     *
     * @param SurveyVote $surveyVote
     * @return Item
     */
    public function includeSurvey(SurveyVote $surveyVote)
    {
        return $this->item($surveyVote->survey, new SurveyTransformer);
    }
}