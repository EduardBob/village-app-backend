<?php

namespace Modules\Village\Packback\Transformer;

use League\Fractal\Resource\Item;
use Modules\Village\Entities\Margin;
use Modules\Village\Entities\Service;

class ServiceTransformer extends BaseTransformer
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
            'price' => Margin::getFinalPrice($service->village, $service->price),
            'comment_label' => $service->comment_label,
            'order_button_label' => $service->order_button_label,
            'show_perform_time' => $service->show_perform_time,
            'has_card_payment' => $service->has_card_payment,
            'text' => $service->text,
            'image' => $this->getImage($service->files()->first()),
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