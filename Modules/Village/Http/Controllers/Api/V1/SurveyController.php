<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Modules\Village\Entities\Survey;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Modules\Village\Entities\SurveyVote;
use Modules\Village\Packback\Transformer\SurveyTransformer;
use Modules\Village\Packback\Transformer\SurveyVoteTransformer;
use Request;
use Validator;

class SurveyController extends ApiController
{
    /**
     * Get current survey
     *
     * @return Response
     */
    public function current()
    {
        $survey = Survey::getCurrent();
        if (!$survey) {
            return $this->response->withArray([]);
        }

        return $this->response->withItem($survey, new SurveyTransformer($this->user()));
    }

    /**
     * Survey Vote
     *
     * @param integer $surveyId
     * @param Request $request
     *
     * @return mixed
     */
    public function vote($surveyId, Request $request)
    {
        $data = $request::only(['choice']);
        $data['survey_id'] = (int)$surveyId;

        $validator = Validator::make($data, [
            'survey_id' => 'required|exists:village__surveys,id',
            'choice'    => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors());
        }

        $survey = Survey::api()->where('id', $data['survey_id'])->first();
        if(!$survey){
            return $this->response->errorNotFound('survey_not_found');
        }

        $options = json_decode($survey->options, true);
        if (!is_array($options) || !isset($options[$data['choice']])) {
            return $this->response->errorNotFound('survey_choice_not_found');
        }

        $data['user_id'] = $this->user()->id;
        $surveyVote = SurveyVote::updateOrCreate(['user_id' => $this->user()->id, 'survey_id' => $survey->id], $data);

        return $this->response->withItem($surveyVote, new SurveyVoteTransformer);
    }
}