<?php namespace Modules\Village\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use Modules\Village\Entities\Margin;
use Modules\Village\Repositories\MarginRepository;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Validator;
use yajra\Datatables\Engines\EloquentEngine;
use yajra\Datatables\Html\Builder as TableBuilder;

class MarginController extends AdminController
{
    /**
     * @param MarginRepository $margin
     */
    public function __construct(MarginRepository $margin)
    {
        parent::__construct($margin, Margin::class);
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'margins';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Model $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Model $model)
    {
        if (!$model->is_removable)
        {
            flash()->error($this->trans('messages.not_removable', ['name' => $this->trans('title.margin')]));

            return redirect()->route($this->getRoute('index'));
        } else {
            return parent::destroy($model);
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridColumns()
    {
        return [
            'village__margins.id',
            'village__margins.village_id',
            'village__margins.title',
            'village__margins.type',
            'village__margins.value',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
        $query
            ->join('village__villages', 'village__margins.village_id', '=', 'village__villages.id')
            ->with(['village'])
        ;

        if (!$this->getCurrentUser()->inRole('admin')) {
            $query->where('village__margins.village_id', $this->getCurrentUser()->village->id);
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
            ->addColumn(['data' => 'title', 'name' => 'village__margins.title', 'title' => $this->trans('table.title')])
            ->addColumn(['data' => 'type', 'name' => 'village__margins.type', 'title' => $this->trans('table.type')])
            ->addColumn(['data' => 'value', 'name' => 'village__margins.value', 'title' => $this->trans('table.value')])
        ;
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        if ($this->getCurrentUser()->inRole('admin')) {
            $dataTable
                ->editColumn('village_name', function (Margin $margin) {
                    if ($this->getCurrentUser()->hasAccess('village.villages.edit')) {
                        return '<a href="'.route('admin.village.village.edit', ['id' => $margin->village->id]).'">'.$margin->village->name.'</a>';
                    }
                    else {
                        return $margin->village->name;
                    }
                })
            ;
        }

        $dataTable
            ->addColumn('type', function (Margin $margin) {
                return $this->trans('form.type.values.'.$margin->type);
            })
        ;
    }

    /**
     * @param array  $data
     * @param Margin $margin
     *
     * @return Validator
     */
    public function validate(array $data, Margin $margin = null)
    {
        $marginId = $margin ? $margin->id : '';

        $rules = [
            'title' => "required|max:255|unique:village__margins,title,{$marginId}",
            'value' => 'required|numeric|min:0',
            'type' => 'required|in:'.implode(',', Margin::getTypes()),
            'order' => 'required|integer|min:1',
            'is_removable' => 'boolean'
        ];

        if ($this->getCurrentUser()->inRole('admin')) {
            $rules['village_id'] = 'required|exists:village__villages,id';
        }

        return Validator::make($data, $rules);
    }
}
