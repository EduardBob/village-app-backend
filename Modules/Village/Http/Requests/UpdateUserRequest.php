<?php

namespace Modules\Village\Http\Requests;

class UpdateUserRequest extends \Modules\User\Http\Requests\UpdateUserRequest
{
    public function rules()
    {
        $userId = $this->route()->getParameter('users');

        return [
            // rewrite
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'min:6|confirmed',

            // new
            'phone' => "required|unique:users,phone,{$userId}|regex:".config('village.user.phone.regex'),
            'building_id' => 'exists:village__buildings,id',
        ];
    }
}