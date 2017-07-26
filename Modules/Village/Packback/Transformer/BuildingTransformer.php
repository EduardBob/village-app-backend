<?php

namespace Modules\Village\Packback\Transformer;

use Modules\Village\Entities\Building;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class BuildingTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['village'];

    /**
     * List of resources to automatically include
     *
     * @var  array
     */
    protected $defaultIncludes = ['village'];

    /**
     * Turn building object into generic array
     *
     * @param Building $building
     * @return array
     */
    public function transform(Building $building)
    {
        return [
            'id' => (int) $building->id,
            'address' => $building->address,
            'link' => $building->link,
        ];
    }

    /**
     * Include village
     *
     * @param Building $building
     * @return Item
     */
    public function includeVillage(Building $building)
    {
        return $this->item($building->village, new VillageTransformer());
    }
}