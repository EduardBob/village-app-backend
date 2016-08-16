<?php namespace Modules\Village\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Village\Entities\BaseSurvey;
use Modules\Village\Entities\Survey;
use Modules\Village\Entities\SurveyVote;
use Modules\Village\Repositories\SurveyRepository;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Validator;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Html\Builder as TableBuilder;

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
     * @inheritdoc
     */
    protected function configureDatagridColumns()
    {
        return [
            'village__surveys.id',
            'village__surveys.village_id',
            'village__surveys.title',
            'village__surveys.ends_at',
            'village__surveys.active',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
        $query
            ->join('village__villages', 'village__surveys.village_id', '=', 'village__villages.id')
            ->where('village__villages.deleted_at', null)
            ->with(['village'])
        ;

        if (!$this->getCurrentUser()->inRole('admin')) {
            $query->where('village__surveys.village_id', $this->getCurrentUser()->village->id);
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {
        $builder
            ->addColumn(['data' => 'id', 'name' => 'village__surveys.id', 'title' => $this->trans('table.id')])
        ;

        if ($this->getCurrentUser()->inRole('admin')) {
            $builder
                ->addColumn(['data' => 'village_name', 'name' => 'village__villages.name', 'title' => trans('village::villages.title.model')])
            ;
        }
        $builder
            ->addColumn(['data' => 'title', 'name' => 'village__surveys.title', 'title' => $this->trans('table.title')])
            ->addColumn(['data' => 'ends_at', 'name' => 'village__surveys.ends_at', 'title' => $this->trans('table.ends_at')])
            ->addColumn(['data' => 'active', 'name' => 'village__surveys.active', 'title' => $this->trans('table.active')])
        ;
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        if ($this->getCurrentUser()->inRole('admin')) {
            $dataTable
                ->editColumn('village_name', function (Survey $survey) {
                    if ($this->getCurrentUser()->hasAccess('village.villages.edit')) {
                        return '<a href="'.route('admin.village.village.edit', ['id' => $survey->village->id]).'">'.$survey->village->name.'</a>';
                    }
                    else {
                        return $survey->village->name;
                    }
                })
            ;
        }

        $dataTable
            ->addColumn('title', function (Survey $survey) {
                if ($this->getCurrentUser()->hasAccess($this->getAccess('edit'))) {
                    return '<a href="'.$this->route('edit', ['id' => $survey->id]).'">'.$survey->title.'</a>';
                }
                else {
                    return $survey->title;
                }
            })
            ->addColumn('ends_at', function (Survey $survey) {
                return localizeddate($survey->ends_at, 'short');
            })
            ->addColumn('active', function (Survey $survey) {
                if($survey->active) {
                    return '<span class="label label-success">'.trans('village::admin.table.active.yes').'</span>';
                }
                else {
                    return '<span class="label label-danger">'.trans('village::admin.table.active.no').'</span>';
                }
            })
        ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function preStore(Model $model, Request $request)
    {
        parent::preStore($model, $request);

        if ($request->get('show_all')) {
            $baseModel = new BaseSurvey();
            $data = $model->toArray();
            $data['active'] = 1;
            $baseModel->fill($data)->save();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Model $model
     * @return \Illuminate\View\View
     */
    public function edit($model)
    {
        $response = parent::edit($model);

        view()->share('votesCount', SurveyVote::countVotesBySurvey($model));
        view()->share('totalVotes', SurveyVote::countTotalVotesBySurvey($model));

        return $response;
    }

    /**
     * @param int $baseId
     *
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function baseCopy($baseId)
    {
        $model = BaseSurvey::find($baseId);

        if (!$this->getCurrentUser()->inRole('admin') && !$model->active) {
            return redirect()->route($this->getRoute('index'));
        }

        return view($this->getView('baseCopy'), $this->mergeViewData(compact('model')));
    }

    /**
     * @param array  $data
     * @param Survey $survey
     *
     * @return Validator
     */
    public function validate(array $data, Survey $survey = null)
    {
        $rules = [
            'title' => "required|max:255",
            'ends_at' => 'required|date|date_format:Y-m-d',
            'options' => "required|array",
        ];

//        foreach((array)@$data['options'] as $key => $val) {
//            $rules['options.'.$key] = 'required|max:100';
//        }

        if ($this->getCurrentUser()->inRole('admin')) {
            $rules['village_id'] = 'required|exists:village__villages,id';
        }

        return Validator::make($data, $rules);
    }
}
