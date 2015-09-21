<?php namespace Modules\Village\Http\Controllers\Admin;

use Modules\Village\Entities\Survey;
use Modules\Village\Repositories\SurveyRepository;

use Validator;

class SurveyController extends AdminController
{
    /**
     * @param SurveyRepository $survey
     */
    public function __construct(SurveyRepository $survey)
    {
        parent::__construct($survey, Survey::class);
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'surveys';
    }

    /**
     * @param array  $data
     * @param Survey $survey
     *
     * @return Validator
     */
    static function validate(array $data, Survey $survey = null)
    {
        return Validator::make($data, [
            'title' => "required|max:255",
            'ends_at' => 'required|date|date_format:'.config('village.date.format'),
            'active' => "required|boolean",
        ]);
    }
}
