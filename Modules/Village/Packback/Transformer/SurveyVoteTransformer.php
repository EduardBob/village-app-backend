<?php

namespace Modules\Village\Packback\Transformer;

use League\Fractal\TransformerAbstract;
use Modules\Village\Entities\SurveyVote;

class SurveyVoteTransformer extends TransformerAbstract
{
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
}