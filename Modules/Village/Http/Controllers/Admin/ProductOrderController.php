<?php namespace Modules\Village\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\Village\Entities\ProductOrder;
use Modules\Village\Repositories\ProductOrderRepository;

use Modules\Village\Entities\Product;
use Validator;

class ProductOrderController extends AdminController
{
    /**
     * @param ProductOrderRepository $productOrder
     */
    public function __construct(ProductOrderRepository $productOrder)
    {
        parent::__construct($productOrder, ProductOrder::class);
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'productorders';
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
            'product_id' => 'required|exists:village__products,id',
            'perform_at' => 'required|date|date_format:'.config('village.date.format'),
            'status' => 'required|in:'.implode(',', config('village.order.statuses')),
            'comment' => 'sometimes|required|string',
            'decline_reason' => 'sometimes|required_if:status,rejected|string',
            'quantity' => 'required|numeric|min:1'
        ]);
    }
}
