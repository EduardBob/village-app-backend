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
    protected $availableIncludes = ['service'];

    /**
     * List of resources to automatically include
     *
     * @var  array
     */
    protected $defaultIncludes = ['service'];

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
            'status' => $serviceOrder->status,
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
}