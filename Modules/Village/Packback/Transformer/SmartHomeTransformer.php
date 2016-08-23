<?php

namespace Modules\Village\Packback\Transformer;
use Modules\Village\Entities\SmartHome;

class SmartHomeTransformer extends BaseTransformer
{

    /**
     * Turn article object into generic array
     *
     * @param SmartHome $smartHome
     *
     * @return array
     */
    public function transform(SmartHome $smartHome)
    {
        return [
          'id'      => $smartHome->id,
          'name'    => $smartHome->name,
          'api'     => $smartHome->api,
        ];
    }
}