<?php namespace Modules\Village\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Village\Entities\Building;
use Modules\Village\Repositories\BuildingRepository;
use Validator;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Html\Builder as TableBuilder;

class BuildingController extends AdminController
{
    /**
     * @param BuildingRepository $building
     */
    public function __construct(BuildingRepository $building)
    {
        parent::__construct($building, Building::class);
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'buildings';
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridColumns()
    {
        return [
            'village__buildings.id',
            'village__buildings.village_id',
            'village__buildings.address',
            'village__buildings.code'
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
        $query
            ->join('village__villages', 'village__buildings.village_id', '=', 'village__villages.id')
            ->where('village__villages.deleted_at', null)
            ->with(['village'])
        ;

        if (!$this->getCurrentUser()->inRole('admin')) {
            $query->where('village__buildings.village_id', $this->getCurrentUser()->village->id);
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {
        $builder
            ->addColumn(['data' => 'id', 'name' => 'village__buildings.id', 'title' => $this->trans('table.id')])
        ;

        if ($this->getCurrentUser()->inRole('admin')) {
            $builder
                ->addColumn(['data' => 'village_name', 'name' => 'village__villages.name', 'title' => trans('village::villages.title.model')])
            ;
        }
        $builder
            ->addColumn(['data' => 'address', 'name' => 'village__buildings.address', 'title' => $this->trans('table.address')])
            ->addColumn(['data' => 'code', 'name' => 'village__buildings.code', 'title' => $this->trans('table.code')])
        ;
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        if ($this->getCurrentUser()->inRole('admin')) {
            $dataTable
                ->editColumn('village_name', function (Building $building) {
                    if ($this->getCurrentUser()->hasAccess('village.villages.edit')) {
                        return '<a href="'.route('admin.village.village.edit', ['id' => $building->village->id]).'">'.$building->village->name.'</a>';
                    }
                    else {
                        return $building->village->name;
                    }
                })
            ;
        }
    }

    /**
     * @param array    $data
     * @param Building $building
     *
     * @return Validator
     */
    public function validate(array $data, Building $building = null)
    {
        $buildingId = $building ? $building->id : '';

        $rules = [
            'address' => "required|max:255|unique:village__buildings,address,{$buildingId}",
            'link' => "required|url|max:255",
        ];

        if ($this->getCurrentUser()->inRole('admin')) {
            $rules['village_id'] = 'required|exists:village__villages,id';
        }

        return Validator::make($data, $rules);
    }

    /**
     * @param $code
     *
     * @return mixed
     */
    public function checkRecord($code)
    {
        return $this->getRepository()->all()->where('code', $code)->first();
    }

    public function getChoicesByVillage($villageId, $selectedBuildingId = null)
    {
        $attributes = [];
        if ($this->getCurrentUser()->inRole('admin')) {
            $attributes['village_id'] = $villageId;
        }
        else {
            $attributes['village_id'] = $this->getCurrentUser()->village_id;
        }

        $buildings = $this->getRepository()->lists($attributes, 'address', 'id', ['address' => 'ASC']);

        if (\Request::ajax()) {
            $html = '<option value="">'.trans('village::users.form.building.placeholder').'</option>';
            foreach($buildings as $id => $address) {
                $selected = $selectedBuildingId == $id ? 'selected="selected"' : '';
                $html .= '<option value="'.$id.'" '.$selected.'>'.$address.'</option>';
            }

            return $html;
        }

        return $buildings;
    }

    public function checkLimit()
    {
        $currentUser = $this->getCurrentUser();
        $village = $currentUser->village;
        if ($currentUser->inRole('admin')) {
            return true;
        }
        if ($village->is_unlimited) {
            return true;
        }
        $limit = (int)setting('village::village-' .$village->type . '-' . $village->packet . '-buildings');
        if (!$limit) {
            return true;
        }
        $total = $this->getRepository()->all()->where('village_id', $village->id)->count();
        if ($limit - $total <= 0) {
            return false;
        }
        return true;
    }
}
