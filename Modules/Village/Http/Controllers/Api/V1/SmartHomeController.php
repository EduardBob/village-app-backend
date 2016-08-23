<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Modules\Village\Entities\SmartHome;
use Modules\Village\Packback\Transformer\SmartHomeTransformer;
use Request;
use Validator;

class SmartHomeController extends ApiController
{

    public function index()
    {
        $smartHome = $this->getSmartHome();
        if (is_object($smartHome)) {
            return $this->response->withItem($smartHome, new SmartHomeTransformer());
        }
        return [];
    }

    private function getSmartHome()
    {
        $smartHome = $this->user()->load('building')->smartHome;
        return $smartHome;
    }

    // TODO make SmartHome api request, now dummy data.
    public function statuses()
    {
        $smartHome = $this->getSmartHome();
        $devices              = [];
        $device               = new \stdClass();
        $device->title        = 'Кофемолка';
        $device->status_label = 'Включена';
        $device->status       = 'on';
        $device->name         = 'cafe_machine';
        $device->image        = 'img-src';
        $devices[]            = $device;

        $device               = new \stdClass();
        $device->title        = 'Вопрота гаража';
        $device->status_label = 'Закрыты';
        $device->status       = 'on';
        $device->name         = 'garage_door';
        $device->image        = 'img-src';
        $devices[]            = $device;

        return ['data' => $devices];
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function add(Request $request)
    {
        if (!$this->getSmartHome()) {
            $data      = $request::only(['name', 'api', 'password']);
            $validator = Validator::make($data, [
              'name'     => 'required',
              'api'      => 'required',
              'password' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->response->errorWrongArgs($validator->errors());
            }
            $smartHome = new SmartHome;
            $smartHome->name = $data['name'];
            $smartHome->api = $data['api'];
            $smartHome->password = $data['password'];
            $user = $this->user()->load('building');
            $user->smartHome()->save($smartHome);

        }
        return $this->index();
    }

    public function delete()
    {
        if ($smartHome = $this->getSmartHome()) {
            $smartHome->delete();
        }
        return $this->index();
    }
}
