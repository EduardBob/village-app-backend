<?php namespace Modules\Village\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Jenssegers\Date\Date;
use Modules\Village\Entities\ServiceOrder;
use Modules\Village\Repositories\ServiceOrderRepository;
use Modules\Village\Entities\Service;
use Modules\Village\Repositories\ServiceRepository;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Validator;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Html\Builder as TableBuilder;

class ServiceOrderController extends AdminController
{
    /**
     * @var ServiceRepository
     */
    private $serviceRepository;

    /**
     * @param ServiceOrderRepository $serviceOrder
     * @param ServiceRepository      $serviceRepository
     */
    public function __construct(ServiceOrderRepository $serviceOrder, ServiceRepository $serviceRepository)
    {
        parent::__construct($serviceOrder, ServiceOrder::class);

        $this->serviceRepository = $serviceRepository;
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'serviceorders';
    }


    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setStatusRunning($id)
    {
        $serviceOrder = $this->repository->find((int)$id);
        if (!$serviceOrder || $serviceOrder->status !== 'processing') {
            return redirect()->back(302);
        }
        $serviceOrder->status = 'running';
        $serviceOrder->save();

        flash()->success($this->trans('messages.resource status-running'));

        return redirect()->route($this->getRoute('index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setStatusDone($id)
    {
        $serviceOrder = $this->repository->find((int)$id);
        if (!$serviceOrder || $serviceOrder->status !== 'running') {
            return redirect()->back(302);
        }

        $serviceOrder->payment_status = 'paid';
        $serviceOrder->status = 'done';
        $serviceOrder->save();

        flash()->success($this->trans('messages.resource status-done'));

        return redirect()->route($this->getRoute('index'));
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridColumns()
    {
        return [
            'village__service_orders.*',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
        $query
            ->leftJoin('village__villages', 'village__service_orders.village_id', '=', 'village__villages.id')
            ->leftJoin('village__services', 'village__service_orders.service_id', '=', 'village__services.id')
            ->leftJoin('users', 'village__service_orders.user_id', '=', 'users.id')
            ->leftJoin('village__buildings', 'users.building_id', '=', 'village__buildings.id')
            ->with(['village', 'service', 'user', 'user.building'])
        ;

        if (!$this->getCurrentUser()->inRole('admin')) {
            $query->where('village__service_orders.village_id', $this->getCurrentUser()->village->id);
        }
        if ($this->getCurrentUser()->inRole('executor')) {
            $query->leftJoin('village__service_executors', 'village__service_executors.service_id', '=', 'village__services.id');
            $query->where('village__service_executors.user_id', $this->getCurrentUser()->id);
            $query->whereIn('village__service_orders.status', ['processing', 'running']);
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {
        $builder
            ->addColumn(['data' => 'id', 'name' => 'village__service_orders.id', 'title' => $this->trans('table.id')])
        ;

        if ($this->getCurrentUser()->inRole('admin')) {
            $builder
                ->addColumn(['data' => 'village_name', 'name' => 'village__villages.name', 'title' => trans('village::villages.title.model')])
            ;
        }

        $builder
            ->addColumn(['data' => 'service_title', 'name' => 'village__services.title', 'title' => $this->trans('table.service')])
            ->addColumn(['data' => 'building_address', 'name' => 'village__buildings.address', 'title' => $this->trans('table.address')])
            ->addColumn(['data' => 'perform_date', 'name' => 'village__service_orders.perform_date', 'title' => $this->trans('table.perform_date')])
            ->addColumn(['data' => 'price', 'name' => 'village__service_orders.price', 'title' => $this->trans('table.price')])
            ->addColumn(['data' => 'user_name', 'name' => 'users.last_name', 'title' => $this->trans('table.name')])
            ->addColumn(['data' => 'user_phone', 'name' => 'users.phone', 'title' => $this->trans('table.phone')])
            ->addColumn(['data' => 'payment_type', 'name' => 'village__service_orders.payment_type', 'title' => $this->trans('table.payment_type')])
            ->addColumn(['data' => 'payment_status', 'name' => 'village__service_orders.payment_status', 'title' => $this->trans('table.payment_status')])
            ->addColumn(['data' => 'status', 'name' => 'village__service_orders.status', 'title' => $this->trans('table.status')])
            ->addColumn(['data' => 'created_at', 'name' => 'village__service_orders.created_at', 'title' => $this->trans('table.created_at')])
        ;
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        if ($this->getCurrentUser()->inRole('admin')) {
            $dataTable
                ->editColumn('village_name', function (ServiceOrder $serviceOrder) {
                    if ($this->getCurrentUser()->hasAccess('village.villages.edit')) {
                        return '<a href="'.route('admin.village.village.edit', ['id' => $serviceOrder->village->id]).'">'.$serviceOrder->village->name.'</a>';
                    }
                    else {
                        return $serviceOrder->village->name;
                    }
                })
            ;
        }

        $dataTable
            ->editColumn('service_title', function (ServiceOrder $serviceOrder) {
                if ($this->getCurrentUser()->hasAccess('village.services.edit')) {
                    return '<a href="'.route('admin.village.service.edit', ['id' => $serviceOrder->service->id]).'">'.$serviceOrder->service->title.'</a>';
                }
                else {
                    return $serviceOrder->service->title;
                }
            })
            ->editColumn('building_address', function (ServiceOrder $serviceOrder) {
                if (!$serviceOrder->user) {
                    return '';
                }
                if ($this->getCurrentUser()->hasAccess('village.buildings.edit') && $serviceOrder->user->building) {
                    return '<a href="'.route('admin.village.building.edit', ['id' => $serviceOrder->user->building->id]).'">'.$serviceOrder->user->building->address.'</a>';
                }
                elseif ($serviceOrder->user->building) {
                    return $serviceOrder->user->building->address;
                }
            })
            ->addColumn('perform_date', function (ServiceOrder $serviceOrder) {
                    return localizeddate($serviceOrder->perform_date, 'short').' '.@mb_strcut($serviceOrder->perform_time, 0, 5);
            })
            ->addColumn('created_at', function (ServiceOrder $serviceOrder) {
                return localizeddate($serviceOrder->created_at);
            })
            ->editColumn('user_name', function (ServiceOrder $serviceOrder) {
                if (!$serviceOrder->user) {
                    return '';
                }
                $name = $serviceOrder->user->last_name. ' '.$serviceOrder->user->first_name;

                if ($this->getCurrentUser()->hasAccess('user.users.edit')) {
                    return '<a href="'.route('admin.user.user.edit', ['id' => $serviceOrder->user->id]).'">'.$name.'</a>';
                }
                else {
                    return $name;
                }
            })
            ->editColumn('user_phone', function (ServiceOrder $serviceOrder) {
                if (!$serviceOrder->user) {
                    return '';
                }
                return $serviceOrder->user->phone;
            })
            ->editColumn('payment_type', function (ServiceOrder $ServiceOrder) {
                return $this->trans('form.payment.type.values.'.$ServiceOrder->payment_type);
            })
            ->editColumn('payment_status', function (ServiceOrder $ServiceOrder) {
                return '<span class="label label-'.config('village.order.payment.status.label.'.$ServiceOrder->payment_status).'">'.$this->trans('form.payment.status.values.'.$ServiceOrder->payment_status).'</span>';
            })
            ->editColumn('status', function (ServiceOrder $serviceOrder) {
                return '<span class="label label-'.config('village.order.label.'.$serviceOrder->status).'">'.$this->trans('form.status.values.'.$serviceOrder->status).'</span>';
            })
        ;
    }

    /**
     * @inheritdoc
     */
    public function store(Request $request)
    {
        $request['status'] = config('village.order.first_status');

        return parent::store($request);
    }

    /**
     * @param array $data
     *
     * @return Validator
     */
    public function validate(array $data)
    {
        return Validator::make($data, [
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:village__services,id',
            'perform_date' => 'required|date|date_format:Y-m-d',
            'perform_time' => 'date_format:H:i',
            'status' => 'required|in:'.implode(',', config('village.order.statuses')),
            'payment_type' => 'required|in:'.implode(',', config('village.order.payment.type.values')),
            'payment_status' => 'required|in:'.implode(',', config('village.order.payment.status.values')),
//            'comment' => 'sometimes|required|string',
            'decline_reason' => 'sometimes|required_if:status,rejected|string',
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getServices()
    {
        if (!method_exists($this->modelClass, 'village') || $this->getCurrentUser()->inRole('admin')){
            return $this->serviceRepository->lists([], 'title', 'id', ['title' => 'asc']);
        }

        return $this->serviceRepository->lists(['village_id' => $this->getCurrentUser()->village->id], 'title', 'id', ['title' => 'asc']);
    }
}
