<?php namespace Modules\Village\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Village\Entities\ServiceOrder;
use Modules\Village\Repositories\ServiceOrderRepository;
use Modules\Village\Entities\Service;
use Modules\Village\Repositories\ServiceRepository;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Validator;
use yajra\Datatables\Engines\EloquentEngine;
use yajra\Datatables\Html\Builder as TableBuilder;

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
            'village__service_orders.id',
            'village__service_orders.village_id',
            'village__service_orders.service_id',
            'village__service_orders.user_id',
            'village__service_orders.perform_at',
            'village__service_orders.price',
            'village__service_orders.status',
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
            $query->where('village__services.executor_id', $this->getCurrentUser()->id);
            $query->whereIn('village__service_orders.status', ['processing', 'running']);
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {
        $builder
            ->addColumn(['data' => 'id', 'title' => $this->trans('table.id')])
        ;

        if ($this->getCurrentUser()->inRole('admin')) {
            $builder
                ->addColumn(['data' => 'village_name', 'name' => 'village__villages.name', 'title' => trans('village::villages.title.model')])
            ;
        }

        $builder
            ->addColumn(['data' => 'service_title', 'name' => 'village__services.title', 'title' => $this->trans('table.service')])
            ->addColumn(['data' => 'building_address', 'name' => 'village__buildings.address', 'title' => $this->trans('table.address')])
            ->addColumn(['data' => 'perform_at', 'name' => 'village__service_orders.perform_at', 'title' => $this->trans('table.perform_at')])
            ->addColumn(['data' => 'price', 'name' => 'village__service_orders.price', 'title' => $this->trans('table.price')])
            ->addColumn(['data' => 'user_name', 'name' => 'users.last_name', 'title' => $this->trans('table.name')])
            ->addColumn(['data' => 'user_phone', 'name' => 'users.phone', 'title' => $this->trans('table.phone')])
            ->addColumn(['data' => 'status', 'name' => 'village__service_orders.status', 'title' => $this->trans('table.status')])
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
                if ($this->getCurrentUser()->hasAccess('village.buildings.edit') && $serviceOrder->user->building) {
                    return '<a href="'.route('admin.village.building.edit', ['id' => $serviceOrder->user->building->id]).'">'.$serviceOrder->user->building->address.'</a>';
                }
                elseif ($serviceOrder->user->building) {
                    return $serviceOrder->user->building->address;
                }
            })
            ->addColumn('perform_at', function (ServiceOrder $serviceOrder) {
                return Carbon::parse($serviceOrder->perform_at)->format(config('village.date.format'));
            })
            ->editColumn('user_name', function (ServiceOrder $serviceOrder) {
                $name = $serviceOrder->user->last_name. ' '.$serviceOrder->user->first_name;

                if ($this->getCurrentUser()->hasAccess('user.users.edit')) {
                    return '<a href="'.route('admin.user.user.edit', ['id' => $serviceOrder->user->id]).'">'.$name.'</a>';
                }
                else {
                    return $name;
                }
            })
            ->editColumn('user_phone', function (ServiceOrder $serviceOrder) {
                return $serviceOrder->user->phone;
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
        $request['status'] = 'processing';

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
            'perform_at' => 'required|date|date_format:'.config('village.date.format'),
            'status' => 'required|in:'.implode(',', config('village.order.statuses')),
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
