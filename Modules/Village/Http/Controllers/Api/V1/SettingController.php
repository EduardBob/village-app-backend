<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Modules\Setting\Entities\Setting;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Modules\Village\Packback\Transformer\SettingTransformer;

class SettingController extends ApiController
{
    /**
     * Get all settings
     *
     * @return Response
     */
    public function index()
    {
        $settings = Setting::all();

        return $this->response->withCollection($settings, new SettingTransformer);
    }
}