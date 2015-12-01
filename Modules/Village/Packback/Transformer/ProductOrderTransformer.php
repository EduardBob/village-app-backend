<?php

namespace Modules\Village\Packback\Transformer;

use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use Modules\Village\Entities\ProductOrder;

class ProductOrderTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['product', 'pay'];

    /**
     * List of resources to automatically include
     *
     * @var  array
     */
    protected $defaultIncludes = ['product', 'pay'];

    /**
     * Turn user object into generic array
     *
     * @param ProductOrder $productOrder
     * @return array
     */
    public function transform(ProductOrder $productOrder)
    {
        return [
            'id' =>  $productOrder->id,
            'created_at' => $productOrder->created_at->format('Y-m-d H:i:s'),
            'perform_at' => $productOrder->perform_at ? $productOrder->perform_at->format(config('village.date.format')) : null,
            'price' => $productOrder->price,
            'unit_title' => $productOrder->unit_title,
            'quantity' => $productOrder->quantity,
            'comment' => $productOrder->comment,
            'status' => $productOrder->status,
            'decline_reason' => $productOrder->decline_reason,
            'payment_type' => $productOrder->payment_type,
            'payment_status' => $productOrder->payment_status,
        ];
    }

    /**
     * Include product in product
     *
     * @param ProductOrder $productOrder
     * @return Item
     */
    public function includeProduct(ProductOrder $productOrder)
    {
        return $this->item($productOrder->product, new ProductTransformer);
    }

    /**
     * Include bank payment form data
     *
     * @param ProductOrder $productOrder
     *
     * @return Item
     */
    public function includePay(ProductOrder $productOrder)
    {
        return $this->item($productOrder, new PayLinkTransformer);
    }
}