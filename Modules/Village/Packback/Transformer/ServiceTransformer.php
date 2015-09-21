<?php

namespace Modules\Village\Packback\Transformer;

use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use Modules\Village\Entities\Service;

class ServiceTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['category'];

    /**
     * List of resources to automatically include
     *
     * @var  array
     */
    protected $defaultIncludes = ['category'];

    /**
     * Turn service object into generic array
     *
     * @param Service $service
     * @return array
     */
    public function transform(Service $service)
    {
        return [
            'id' =>  $service->id,
            'title' => $service->title,
            'price' => $service->price
        ];
    }

    /**
     * Include category in service
     *
     * @param Service $service
     * @return Item
     */
    public function includeCategory(Service $service)
    {
        return $this->item($service->category, new ServiceCategoryTransformer);
    }
}