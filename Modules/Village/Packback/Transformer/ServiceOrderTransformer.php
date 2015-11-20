<?php

namespace Modules\Village\Packback\Transformer;

use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use Modules\Village\Entities\ServiceOrder;

class ServiceOrderTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['service', 'pay'];

    /**
     * List of resources to automatically include
     *
     * @var  array
     */
    protected $defaultIncludes = ['service', 'pay'];

    /**
     * Turn user object into generic array
     *
     * @param ServiceOrder $serviceOrder
     * @return array
     */
    public function transform(ServiceOrder $serviceOrder)
    {
        return [
            'id' =>  $serviceOrder->id,
            'created_at' => $serviceOrder->created_at->format('Y-m-d H:i:s'),
            'price' => $serviceOrder->price,
            'payment_type' => $serviceOrder->payment_type,
            'payment_status' => $serviceOrder->payment_status,
            'status' => $serviceOrder->status,
            'comment' => $serviceOrder->comment,
            'decline_reason' => $serviceOrder->decline_reason,
        ];
    }

    /**
     * Include service in service
     *
     * @param ServiceOrder $serviceOrder
     * @return Item
     */
    public function includeService(ServiceOrder $serviceOrder)
    {
        return $this->item($serviceOrder->service, new ServiceTransformer);
    }

    /**
     * Include bank payment form data
     *
     * @param ServiceOrder $serviceOrder
     *
     * @return Item
     */
    public function includePay(ServiceOrder $serviceOrder)
    {
        return $this->item($serviceOrder, new PayLinkTransformer);
    }
}