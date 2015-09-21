<?php namespace Modules\Village\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\Village\Entities\ServiceOrder;
use Modules\Village\Repositories\ServiceOrderRepository;

use Modules\Village\Entities\Service;
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
     * @param array $data
     *
     * @return Validator
     */
    static function validate(array $data)
    {
        return Validator::make($data, [
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:village__services,id',
            'perform_at' => 'required|date|date_format:'.config('village.date.format'),
            'status' => 'required|in:'.implode(',', config('village.order.statuses')),
            'comment' => 'sometimes|required|string',
            'decline_reason' => 'sometimes|required_if:status,rejected|string',
        ]);
    }
}
