<?php

namespace Modules\Village\Packback\Transformer;

use Lang;
use League\Fractal\TransformerAbstract;
use Modules\Setting\Entities\Setting;

class SettingTransformer extends TransformerAbstract
{
    /**
     * Turn setting object into generic array
     *
     * @param Setting $setting
     * @return array
     */
    public function transform(Setting $setting)
    {
        return [
            'name' => $setting->name,
            'plainValue' => $setting->plainValue
        ];
    }
}