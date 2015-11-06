<?php namespace Modules\Village\Http\Controllers\Admin;

use Carbon\Carbon;
use Jenssegers\Date\Date;
use Modules\Village\Entities\ServiceOrderChange;
use Modules\Village\Repositories\ServiceOrderChangeRepository;
use Modules\Village\Entities\Service;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use yajra\Datatables\Engines\EloquentEngine;
use yajra\Datatables\Html\Builder as TableBuilder;

class ServiceOrderChangeController extends AdminController
{
    /**
     * @param ServiceOrderChangeRepository $serviceOrderChangeRepository
     */
    public function __construct(ServiceOrderChangeRepository $serviceOrderChangeRepository)
    {
        parent::__construct($serviceOrderChangeRepository, ServiceOrderChange::class);
    }

    /**
     * @inheritdoc
     */
    public function getViewName()
    {
        return 'serviceorderchanges';
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridColumns()
    {
        return [
            'village__service_order_changes.id',
            'village__service_order_changes.order_id',
            'village__service_order_changes.user_id',
            'village__service_order_changes.from_status',
            'village__service_order_changes.to_status',
            'village__service_order_changes.created_at',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
        $query
            ->leftJoin('village__service_orders', 'village__service_order_changes.order_id', '=', 'village__service_orders.id')
            ->leftJoin('village__villages', 'village__service_orders.village_id', '=', 'village__villages.id')
            ->leftJoin('village__services', 'village__service_orders.service_id', '=', 'village__services.id')
            ->leftJoin('users', 'village__service_order_changes.user_id', '=', 'users.id')
            ->with(['user', 'order', 'order.village'])
        ;

        if (!$this->getCurrentUser()->inRole('admin')) {
            $query->where('village__service_orders.village_id', $this->getCurrentUser()->village->id);
        }
        if ($this->getCurrentUser()->inRole('executor')) {
            $query->where('village__services.executor_id', $this->getCurrentUser()->id);
            $query->whereIn('village__service_order_changes.from_status', ['processing', 'running']);
            $query->whereIn('village__service_order_changes.to_status', ['processing', 'running']);
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {
        $builder
            ->addColumn(['data' => 'order_id', 'name' => 'village__service_order_changes.order_id', 'title' => $this->trans('table.order')])
        ;

        $builder
            ->addColumn(['data' => 'from_status', 'name' => 'village__service_order_changes.from_status', 'title' => $this->trans('table.from_status')])
            ->addColumn(['data' => 'to_status', 'name' => 'village__service_order_changes.to_status', 'title' => $this->trans('table.to_status')])
            ->addColumn(['data' => 'created_at', 'name' => 'village__service_order_changes.created_at', 'title' => $this->trans('table.created_at')])
            ->addColumn(['data' => 'user_name', 'name' => 'users.last_name', 'title' => $this->trans('table.user')])
//            ->addColumn(['data' => 'service_title', 'name' => 'village__services.title', 'title' => $this->trans('table.service')])
        ;

        if ($this->getCurrentUser()->inRole('admin')) {
            $builder
                ->addColumn(['data' => 'village_name', 'name' => 'village__villages.name', 'title' => trans('village::villages.title.model')])
            ;
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        $dataTable->overrideGlobalSearch(function($parameters) use ($dataTable){
            $orderId = (int)\Request::get('search')['value'];
            if (!$orderId) return;

            $dataTable
                ->getQueryBuilder()
                ->where('village__service_order_changes.order_id', (int)\Request::get('search')['value'])
            ;
        }, []);

        if ($this->getCurrentUser()->inRole('admin')) {
            $dataTable
                ->editColumn('village_name', function (ServiceOrderChange $serviceOrderChange) {
                    if ($this->getCurrentUser()->hasAccess('village.villages.edit')) {
                        return '<a href="'.route('admin.village.village.edit', ['id' => $serviceOrderChange->order->village->id]).'">'.$serviceOrderChange->order->village->name.'</a>';
                    }
                    else {
                        return $serviceOrderChange->order->village->name;
                    }
                })
            ;
        }

        $dataTable
            ->editColumn('order_id', function (ServiceOrderChange $serviceOrderChange) {
                if ($this->getCurrentUser()->hasAccess('village.serviceorders.edit')) {
                    return '<a href="'.route('admin.village.serviceorder.edit', ['id' => $serviceOrderChange->order->id]).'">'.$serviceOrderChange->order->id.'</a>';
                }
                else {
                    return $serviceOrderChange->order->id;
                }
            })
            ->editColumn('service_title', function (ServiceOrderChange $serviceOrderChange) {
                if ($this->getCurrentUser()->hasAccess('village.services.edit')) {
                    return '<a href="'.route('admin.village.service.edit', ['id' => $serviceOrderChange->order->service->id]).'">'.$serviceOrderChange->order->service->title.'</a>';
                }
                else {
                    return $serviceOrderChange->order->service->title;
                }
            })
            ->addColumn('created_at', function (ServiceOrderChange $serviceOrderChange) {
                return Date::parse($serviceOrderChange->created_at)->diffForHumans();
            })
            ->editColumn('user_name', function (ServiceOrderChange $serviceOrderChange) {
                if (!$serviceOrderChange->user) {
                    return '';
                }

                $name = $serviceOrderChange->user->last_name. ' '.$serviceOrderChange->user->first_name;

                if ($this->getCurrentUser()->hasAccess('user.users.edit')) {
                    return '<a href="'.route('admin.user.user.edit', ['id' => $serviceOrderChange->user->id]).'">'.$name.'</a>';
                }
                else {
                    return $name;
                }
            })
            ->editColumn('from_status', function (ServiceOrderChange $serviceOrderChange) {
                return '<span class="label label-'.config('village.order.label.'.$serviceOrderChange->from_status).'">'.trans('village::serviceorders.form.status.values.'.$serviceOrderChange->from_status).'</span>';
            })
            ->editColumn('to_status', function (ServiceOrderChange $serviceOrderChange) {
                return '<span class="label label-'.config('village.order.label.'.$serviceOrderChange->to_status).'">'.trans('village::serviceorders.form.status.values.'.$serviceOrderChange->to_status).'</span>';
            })
        ;
    }
}
