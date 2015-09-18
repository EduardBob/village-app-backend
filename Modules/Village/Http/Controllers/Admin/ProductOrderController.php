<?php namespace Modules\Village\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Village\Entities\ProductOrder;
use Modules\Village\Repositories\ProductOrderRepository;

use Modules\Village\Entities\Product;
use Modules\User\Entities\Sentinel\User;
use Validator;

class ProductOrderController extends AdminController
{
    /**
     * @param ProductOrderRepository $productOrder
     */
    public function __construct(ProductOrderRepository $productOrder)
    {
        parent::__construct($productOrder);

        $this->productOrder = $productOrder;
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'productorders';
    }

    /**
     * @param Model   $model
     * @param Request $request
     */
    public function preStore(Model $model, Request $request)
    {
        $product = Product::find($request['product']);
        $user = User::find($request['profile']);

        /** @var ProductOrder $model */
        $model->product()->associate($product);
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
            'product' => 'required|exists:village__products,id',
            'quantity' => 'required|numeric|min:1'
        ]);
    }
}
