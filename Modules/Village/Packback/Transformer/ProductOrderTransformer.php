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
    protected $availableIncludes = ['product'];

    /**
     * List of resources to automatically include
     *
     * @var  array
     */
    protected $defaultIncludes = ['product'];

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
            'price' => $productOrder->price,
            'quantity' => $productOrder->quantity,
            'unit_title' => $productOrder->unit_title,
            'payment_type' => $productOrder->payment_type,
            'payment_status' => $productOrder->payment_status,
            'status' => $productOrder->status,
            'comment' => $productOrder->comment,
            'decline_reason' => $productOrder->decline_reason,
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
}