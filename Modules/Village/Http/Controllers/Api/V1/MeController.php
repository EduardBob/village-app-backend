<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use DB;
use Hash;
use Modules\Village\Entities\Token;
use Modules\Village\Packback\Transformer\UserTransformer;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use JWTAuth;
use Request;
use Validator;

class MeController extends ApiController
{
    public function me()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return $this->response->errorNotFound('user_not_found');
            }

        } catch (TokenExpiredException $e) {

            return $this->response->errorUnauthorized('token_expired');

        } catch (TokenInvalidException $e) {

            return $this->response->errorWrongArgs('token_invalid');

        } catch (JWTException $e) {

            return $this->response->errorInternalError('token_absent');
        }

        // the token is valid and we have found the user via the sub claim
        return $this->response->withItem($user->load('building'), new UserTransformer);
    }


    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function changeName(Request $request)
    {
        $data = $request::only(['first_name', 'last_name']);

        $validator = Validator::make($data, [
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors());
        }

        $this->user()->update($data);

        return $this->response->withItem($this->user()->load('building'), new UserTransformer);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function changePassword(Request $request)
    {
        $data = $request::only(['password', 'new_password', 'new_password_confirmation']);

        $validator = Validator::make($data, [
            'password' => 'required|min:6',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors());
        }

        if (!Hash::check($data['password'], $this->user()->password)) {
            return $this->response->errorWrongArgs(['error' => 'wrong_password']);
        }

        $data = ['password' => Hash::make($data['new_password'])];
        $this->user()->update($data);

        return $this->response->withItem($this->user()->load('building'), new UserTransformer);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function changePhone(Request $request)
    {
        $data = $request::only(['session', 'code']);

        $validator = Validator::make($data, [
            // token
            'session' => 'required',
            'code'    => 'required',
        ]);

        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors());
        }

        $token = Token::findOneByTypeAndSessionAndCode(Token::TYPE_CHANGE_PHONE, $data['session'], $data['code']);
        if (!$token) {
            return $this->response->errorNotFound('token_not_found');
        }
        unset($data['session'], $data['code']);

        $data = [
            'phone' => $token['new_phone'],
            'email' => $token['new_phone'].'@village.dev'
        ];

        $user = $this->user();

        try {
            DB::transaction(function() use ($user, $data, $token) {
                $user->update($data);
                $token->delete();
            });
        }
        catch (\Exception $e) {
            return $this->response->errorInternalError('internal_error');
        }


        return $this->response->withItem($this->user()->load('building'), new UserTransformer);
    }
}