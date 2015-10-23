<?php namespace Modules\Village\Http\Controllers\Admin;

use Modules\Village\Entities\SurveyVote;
use Modules\Village\Repositories\SurveyRepository;
use Modules\Village\Repositories\SurveyVoteRepository;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Validator;
use yajra\Datatables\Engines\EloquentEngine;
use yajra\Datatables\Html\Builder as TableBuilder;

class SurveyVoteController extends AdminController
{
    /**
     * @var SurveyRepository
     */
    private $surveyRepository;

    /**
     * @param SurveyVoteRepository $surveyVoteRepository
     * @param SurveyRepository     $surveyRepository
     */
    public function __construct(SurveyVoteRepository $surveyVoteRepository, SurveyRepository $surveyRepository)
    {
        parent::__construct($surveyVoteRepository, SurveyVote::class);

        $this->surveyRepository = $surveyRepository;
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'surveyvotes';
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridColumns()
    {
        return [
            'village__survey_votes.id',
            'village__survey_votes.village_id',
            'village__survey_votes.survey_id',
            'village__survey_votes.user_id',
            'village__survey_votes.choice',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
        $query
            ->join('village__villages', 'village__survey_votes.village_id', '=', 'village__villages.id')
            ->join('village__surveys', 'village__survey_votes.village_id', '=', 'village__surveys.id')
            ->join('users', 'village__survey_votes.user_id', '=', 'users.id')
            ->with(['village', 'survey', 'user'])
        ;

        if (!$this->getCurrentUser()->inRole('admin')) {
            $query->where('village__survey_votes.village_id', $this->getCurrentUser()->village->id);
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {
        if ($this->getCurrentUser()->inRole('admin')) {
            $builder
                ->addColumn(['data' => 'village_name', 'name' => 'village__villages.name', 'title' => trans('village::villages.title.model')])
            ;
        }
        $builder
            ->addColumn(['data' => 'survey_title', 'name' => 'village__surveys.title', 'title' => $this->trans('table.survey')])
            ->addColumn(['data' => 'user_name', 'name' => 'users.last_name', 'title' => $this->trans('table.user')])
            ->addColumn(['data' => 'choice', 'name' => 'village__survey_votes.choice', 'title' => $this->trans('table.choice')])
        ;
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        if ($this->getCurrentUser()->inRole('admin')) {
            $dataTable
                ->editColumn('village_name', function (SurveyVote $surveyVote) {
                    if ($this->getCurrentUser()->hasAccess('village.villages.edit')) {
                        return '<a href="'.route('admin.village.village.edit', ['id' => $surveyVote->village->id]).'">'.$surveyVote->village->name.'</a>';
                    }
                    else {
                        return $surveyVote->village->name;
                    }
                })
            ;
        }

        $dataTable
            ->addColumn('survey_title', function (SurveyVote $surveyVote) {
                if ($this->getCurrentUser()->hasAccess('village.surveys.edit')) {
                    return '<a href="'.route('admin.village.survey.edit', ['id' => $surveyVote->survey->id]).'">'.$surveyVote->survey->title.'</a>';
                }
                else {
                    return $surveyVote->survey->title;
                }
            })
            ->editColumn('user_name', function (SurveyVote $surveyVote) {
                $name = $surveyVote->user->last_name. ' '.$surveyVote->user->first_name;

                if ($this->getCurrentUser()->hasAccess('user.users.edit')) {
                    return '<a href="'.route('admin.user.user.edit', ['id' => $surveyVote->user->id]).'">'.$name.'</a>';
                }
                else {
                    return $name;
                }
            })
        ;
    }

    /**
     * @param array $data
     *
     * @return Validator
     */
    public function validate(array $data)
    {
        return Validator::make($data, [
            'user' => 'required|exists:users,id',
            'survey' => 'required|exists:village__survey_votes,id',
            'choice' => 'required|integer|min:0',
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getSurveys()
    {
        if ($this->getCurrentUser()->inRole('admin')){
            return $this->surveyRepository->lists([], 'title', 'id', ['ends_at' => 'desc']);
        }

        return $this->surveyRepository->lists(['village_id' => $this->getCurrentUser()->village->id], 'title', 'id', ['ends_at' => 'asc']);
    }
}
