<?php namespace Modules\Village\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Modules\Village\Entities\Village;
use Modules\Village\Repositories\VillageRepository;
use Validator;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Html\Builder as TableBuilder;

class VillageController extends AdminController
{
    /**
     * @param VillageRepository $village
     */
    public function __construct(VillageRepository $village)
    {
        parent::__construct($village, Village::class);
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'villages';
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridColumns()
    {
        return ['village__villages.*'];
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {
        $builder
          ->addColumn(['data'  => 'id',
                       'name'  => 'village__villages.id',
                       'title' => $this->trans('table.id')
          ])
          ->addColumn(['data'  => 'name',
                       'name'  => 'village__villages.name',
                       'title' => $this->trans('table.name')
          ])
          ->addColumn(['data'  => 'shop_name',
                       'name'  => 'village__villages.shop_name',
                       'title' => $this->trans('table.shop_name')
          ])
          ->addColumn(['data'  => 'shop_address',
                       'name'  => 'village__villages.shop_address',
                       'title' => $this->trans('table.shop_address')
          ])
          ->addColumn(['data'  => 'active',
                       'name'  => 'village__villages.active',
                       'title' => $this->trans('table.active')
          ])
          ->addColumn(['data'  => 'created_at',
                       'name'  => 'village__villages.created_at',
                       'title' => $this->trans('table.created_at')
          ]);
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        $dataTable
          ->addColumn('created_at', function (Village $village) {
              return localizeddate($village->created_at);
          });

        $dataTable
          ->addColumn('active', function (Village $village) {
              return boolField($village->active);
          });
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
        // TODO make a special User Permission for this (edit own, create own).
        if (!$this->getCurrentUser()->inRole('admin')) {
            $query->where('village__villages.id', $this->getCurrentUser()->village->id);
        }
    }

    /**
     * @param Model $model
     *
     * @return false|\Illuminate\Http\RedirectResponse
     */
    protected function checkPermissionDenied(Model $model)
    {
        if (method_exists($model, 'village') && !$this->getCurrentUser()->inRole('admin')) {
            if (!$model->village || (int)$model->village->id !== (int)$this->getCurrentUser()->village->id) {
                return redirect()->route($this->getRoute('index'));
            }
        }
        // TODO make a special User Permission for this (edit own, create own).
        if (!$this->getCurrentUser()->inRole('admin') && $model->id != $this->getCurrentUser()->village->id) {
            return redirect()->route($this->getRoute('index'));
        }
        return false;
    }

    /**
     * @param array    $data
     * @param Village $village
     *
     * @return Validator
     */
    public function validate(array $data, Village $village = null)
    {

        $villageId = $village ? $village->id : '';
//        $mainAdminId = $village ? $village->main_admin_id : '';
        return Validator::make($data, [
            'name' => "required|max:50|unique:village__villages,name,{$villageId}",
            'type' => "required",
            'main_admin_id' => "required|max:50", //|unique:users,name,{$mainAdminId}
            'shop_name' => "required|max:50",
            'shop_address' => "required|max:100",
//            'service_payment_info' => "required|max:255",
//            'service_bottom_text' => "required|max:255",
//            'product_payment_info' => "required|max:255",
//            'product_bottom_text' => "required|max:255",
            'product_unit_step_kg' => "required|numeric|max:10",
            'product_unit_step_bottle' => "required|integer|max:10",
            'product_unit_step_piece' => "required|integer|max:10",
        ]);
    }
}
