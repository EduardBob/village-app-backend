<?php

namespace Modules\Village\Http\Requests;

class LoginRequest extends \Modules\User\Http\Requests\LoginRequest
{
    public function rules()
    {
        return [
            'phone' => 'required',
            'password' => 'required',
        ];
    }
}
