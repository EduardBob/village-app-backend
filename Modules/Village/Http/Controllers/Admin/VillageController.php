<?php namespace Modules\Village\Http\Controllers\Admin;

use Modules\Village\Entities\Village;
use Modules\Village\Repositories\VillageRepository;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Validator;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Html\Builder as TableBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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
              if ($village->active) {
                  return '<span class="label label-success">' . trans('village::admin.table.active.yes') . '</span>';
              } else {
                  return '<span class="label label-danger">' . trans('village::admin.table.active.no') . '</span>';
              }
          });
    }

    private function getImportantContacts(Request $request)
    {
        $data = $request->all();
        $importantContacts = false;
        if(count($data['telephone_title']))
        {
            foreach($data['telephone_title'] as $key => $phoneTitle)
            {
                if(strlen($phoneTitle) && strlen($data['telephone_number'][$key]))
                   $phones[$key] = array($phoneTitle, $data['telephone_number'][$key]);
            }
            if(count($phones)) {
                $importantContacts = serialize($phones);
            }

        }
        return $importantContacts;
    }

    public function preUpdate(Model $model, Request $request)
    {
        if( $importantContacts = $this->getImportantContacts( $request))
        {
            $model->important_contacts = $importantContacts;
        }
        parent::preUpdate($model, $request);
    }

    public function preStore(Model $model, Request $request)
    {
        if( $importantContacts = $this->getImportantContacts( $request))
        {
            $model->important_contacts = $importantContacts;
        }
        parent::preStore($model, $request);
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
        return Validator::make($data, [
            'name' => "required|max:50|unique:village__villages,name,{$villageId}",
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
