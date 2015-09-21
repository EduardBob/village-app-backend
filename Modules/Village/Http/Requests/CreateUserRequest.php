<?php

namespace Modules\Village\Http\Requests;

class CreateUserRequest extends \Modules\User\Http\Requests\CreateUserRequest
{
    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                // rewrite
                'password' => 'required|min:6|confirmed',

                // new
                'phone' => 'required|unique:users|regex:'.config('village.user.phone.regex'),
                'building_id' => 'exists:village__buildings,id',
//                'activated' => "required|boolean",
            ]
        );
    }
}
