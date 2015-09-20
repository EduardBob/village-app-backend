<?php namespace Modules\Village\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Village\Entities\ServiceOrder;
use Modules\Village\Repositories\ServiceOrderRepository;

use Modules\Village\Entities\Service;
use Modules\User\Entities\Sentinel\User;
use Validator;

class ServiceOrderController extends AdminController
{
    /**
     * @param ServiceOrderRepository $serviceOrder
     */
    public function __construct(ServiceOrderRepository $serviceOrder)
    {
        parent::__construct($serviceOrder, ServiceOrder::class);
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'serviceorders';
    }

    /**
     * @inheritdoc
     */
    public function store(Request $request)
    {
        $request['status'] = 'in_progress';

        return parent::store($request);
    }

    /**
     * @param Model   $model
     * @param Request $request
     */
    public function preStore(Model $model, Request $request)
    {
        $service = Service::find($request['service']);
        $user = User::find($request['profile']);

        /** @var ServiceOrder $model */
        $model->service()->associate($service);
        $model->profile()->associate($user->profile());
    }

    /**
     * @param Model   $model
     * @param Request $request
     */
    public function preUpdate(Model $model, Request $request)
    {
        $this->preStore($model, $request);
    }

    /**
     * @param array $data
     *
     * @return Validator
     */
    static function validate(array $data)
    {
        return Validator::make($data, [
            'perform_at' => 'required|date|date_format:'.config('village.date.format'),
            'status' => 'required|in:'.implode(',', config('village.order.statuses')),
            'comment' => 'sometimes|required|string',
            'decline_reason' => 'sometimes|required_if:status,rejected|string',
            'profile' => 'required|exists:village__profiles,id',
            'service' => 'required|exists:village__services,id'
        ]);
    }
}
