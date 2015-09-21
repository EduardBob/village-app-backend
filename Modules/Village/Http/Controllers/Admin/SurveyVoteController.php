<?php namespace Modules\Village\Http\Controllers\Admin;

use Modules\Village\Entities\SurveyVote;
use Modules\Village\Repositories\SurveyVoteRepository;
use Validator;

class SurveyVoteController extends AdminController
{
    /**
     * @param SurveyVoteRepository $surveyVote
     */
    public function __construct(SurveyVoteRepository $surveyVote)
    {
        parent::__construct($surveyVote, SurveyVote::class);
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'surveyvotes';
    }

    /**
     * @param array $data
     *
     * @return Validator
     */
    static function validate(array $data)
    {
        return Validator::make($data, [
            'user' => 'required|exists:users,id',
            'survey' => 'required|exists:village__surveys,id',
            'choice' => 'required|integer|min:0',
        ]);
    }
}
