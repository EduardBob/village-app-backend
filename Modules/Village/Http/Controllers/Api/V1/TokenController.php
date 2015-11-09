<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Fruitware\ProstorSms\Exception\BadSmsStatusException;
use Modules\Village\Entities\Sms;
use Modules\Village\Entities\Token;
use Modules\Village\Entities\User;
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

        if (in_array($data['type'], [Token::TYPE_CHANGE_PHONE, Token::TYPE_RESET_PASSWORD])) {
            $user = User::where(['phone' => $data['phone']])->first();

            /** @var $user User */
            if (!$user) {
                return $this->response->errorForbidden('user_not_found');
            }

            if (!$user->isActivated()) {
                return $this->response->errorForbidden('user_not_activated');
            }

            $token = Token::create($data);

            $text = '';
            if (Token::TYPE_CHANGE_PHONE == $token->type) {
                $text = 'Код подтверждения смены номера телефона'.$token->code;
            }
            elseif(Token::TYPE_RESET_PASSWORD == $token->type) {
                $text = 'Код подтверждения сброса пароля'.$token->code;
            }

            if (!$text) {
                return $this->response->errorInternalError('internal_error');
            }

            $sms = new Sms();
            $sms->village()->associate($user->village_id);
            $sms
                ->setPhone($user->phone)
                ->setText($text)
            ;

            if (($response = $this->sendSms($sms)) !== true) {
                return $response;
            }

            return $this->response->withItem($token, new TokenTransformer);
        }
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