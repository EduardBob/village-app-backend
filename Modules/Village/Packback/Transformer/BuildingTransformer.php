<?php

namespace Modules\Village\Packback\Transformer;

use Modules\Village\Entities\Building;
use League\Fractal\TransformerAbstract;

class BuildingTransformer extends TransformerAbstract
{
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
        ];
    }
}