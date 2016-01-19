<?php

namespace Modules\Village\Http\Requests;

class CreateUserRequest extends \Modules\User\Http\Requests\CreateUserRequest
{
    public function rules()
    {
        return [
            // rewrite
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'sometimes|unique:users|email',
            'password' => 'required|min:6|confirmed',

            // new
            'phone' => 'required|unique:users|regex:'.config('village.user.phone.regex'),
            'building_id' => 'exists:village__buildings,id',
        ];
    }
}
