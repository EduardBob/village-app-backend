<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Modules\Village\Entities\Token;
use Modules\Village\Packback\Transformer\TokenTransformer;
use Request;
use Validator;

class TokenController extends ApiController
{
    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $data = $request::only(['type', 'phone', 'new_phone']);

        $validator = Validator::make($data, [
            'type' => 'required|in:'.implode(',', Token::getTypes()),
            'phone' => 'required|regex:'.config('village.user.phone.regex'),
            'new_phone' => 'required_if:type,'.Token::TYPE_CHANGE_PHONE.'|unique:users,phone|regex:'.config('village.user.phone.regex'),
        ]);

        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors());
        }

        $token = Token::create($data);

        return $this->response->withItem($token, new TokenTransformer);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function check(Request $request)
    {
        $data = $request::only(['type', 'session', 'code']);

        $validator = Validator::make($data, [
            'type' => 'required|in:'.implode(',', Token::getTypes()),
            'session' => 'required',
            'code'    => 'required',
        ]);

        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors());
        }

        $token = Token::findOneByTypeAndSessionAndCode($data['type'], $data['session'], $data['code']);
        if (!$token) {
            return $this->response->errorNotFound('not_found');
        }

        return $this->response->withArray(['success' => true]);
    }
}