<?php

namespace Modules\Village\Packback\Transformer;

use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use Modules\Village\Entities\Survey;
use Modules\Village\Entities\SurveyVote;
use Modules\Village\Entities\User;

class SurveyTransformer extends TransformerAbstract
{
    /**
     * @var User
     */
    protected $user;

    public function __construct(User $user = null)
    {
        $this->user = $user;
    }

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['my_vote'];

    /**
     * List of resources to automatically include
     *
     * @var  array
     */
    protected $defaultIncludes = ['my_vote'];

    /**
     * Turn Survey object into generic array
     *
     * @param Survey $survey
     * @return array
     */
    public function transform(Survey $survey)
    {
        return [
            'id' =>  $survey->id,
            'title' => $survey->title,
            'ends_at' => $survey->ends_at->format('Y-m-d'),
            'options' => json_decode($survey->options, true)
        ];
    }

    /**
     * Include my SurveyVote in survey
     *
     * @param Survey $survey
     * @return Item
     */
    public function includeMyVote(Survey $survey)
    {
        if ($this->user) {
            $surveyVote = SurveyVote::findVote($survey, $this->user);
            if ($surveyVote) {
                return $this->item($surveyVote, new SurveyVoteTransformer);
            }
        }
    }
}