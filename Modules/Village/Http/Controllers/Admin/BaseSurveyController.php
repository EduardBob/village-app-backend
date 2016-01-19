<?php namespace Modules\Village\Http\Controllers\Admin;

use Modules\Village\Entities\BaseSurvey;
use Modules\Village\Repositories\BaseSurveyRepository;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Validator;
use yajra\Datatables\Engines\EloquentEngine;
use yajra\Datatables\Html\Builder as TableBuilder;

class BaseSurveyController extends AdminController
{
    /**
     * @param BaseSurveyRepository $survey
     */
    public function __construct(BaseSurveyRepository $survey)
    {
        parent::__construct($survey, BaseSurvey::class);
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'basesurveys';
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridColumns()
    {
        return [
            'village__base__surveys.id',
            'village__base__surveys.title',
            'village__base__surveys.active',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
        if (!$this->getCurrentUser()->inRole('admin')) {
            $query->where('village__base__surveys.active', 1);
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {
        $builder
            ->addColumn(['data' => 'id', 'title' => $this->trans('table.id')])
            ->addColumn(['data' => 'title', 'name' => 'village__base__surveys.title', 'title' => $this->trans('table.title')])
        ;

        if ($this->getCurrentUser()->inRole('admin')) {
            $builder
                ->addColumn(['data' => 'active', 'name' => 'village__base__surveys.active', 'title' => $this->trans('table.active')])
            ;
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        if ($this->getCurrentUser()->inRole('admin')) {
            $dataTable
                ->addColumn('title', function (BaseSurvey $survey) {
                    if ($this->getCurrentUser()->hasAccess($this->getAccess('edit'))) {
                        return '<a href="'.$this->route('edit', ['id' => $survey->id]).'">'.$survey->title.'</a>';
                    }
                    else {
                        return $survey->title;
                    }
                })
                ->addColumn('active', function (BaseSurvey $survey) {
                    if($survey->active) {
                        return '<span class="label label-success">'.trans('village::admin.table.active.yes').'</span>';
                    }
                    else {
                        return '<span class="label label-danger">'.trans('village::admin.table.active.no').'</span>';
                    }
                })
            ;
        }
    }

    /**
     * @param array  $data
     * @param BaseSurvey $survey
     *
     * @return Validator
     */
    public function validate(array $data, BaseSurvey $survey = null)
    {
        $rules = [
            'title' => "required|max:255",
            'options' => "required|array",
        ];

        return Validator::make($data, $rules);
    }
}
