<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Modules\Village\Entities\Building;
use Modules\Village\Packback\Transformer\BuildingTransformer;
use EllipseSynergie\ApiResponse\Contracts\Response;

class BuildingController extends ApiController
{
    /**
     * Get a single building
     *
     * @param string $buildingCode
     * @return Response
     */
    public function show($buildingCode)
    {
        $building = Building::where('code', $buildingCode)->first();
        if(!$building || !$building->village->active){
            return $this->response->errorNotFound('Not Found');
        }

        return $this->response->withItem($building, new BuildingTransformer);
    }
}