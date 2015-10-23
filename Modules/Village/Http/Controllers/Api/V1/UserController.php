<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Activation;
use DB;
use Hash;
use Modules\User\Services\UserRegistration;
use Modules\Village\Entities\Token;
use Modules\Village\Entities\User;
use Modules\Village\Packback\Transformer\TokenTransformer;
use Request;
use Validator;

class UserController extends ApiController
{
    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function registration(Request $request)
    {
        $data = $request::only(['phone', 'building_id']);

        $validator = Validator::make($data, [
            'phone' => 'required|regex:'.config('village.user.phone.regex'),
            'building_id' => 'required|exists:village__buildings,id',
        ]);

        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors());
        }

        /** @var User $user */
        $user = User::where(['phone' => $data['phone']])->first();

        if ($user) {
            if (!$user->isActivated()) {
                $token = Token::findOneByTypeAndPhone(Token::TYPE_REGISTRATION, $data['phone']);
                if ($token) {
                    Token::destroy($token->id);
                }
                $token = Token::create([
                    'type'  => Token::TYPE_REGISTRATION,
                    'phone' => $data['phone'],
                ]);
                return $this->response->withItem($token, new TokenTransformer);
            }
            else {
                return $this->response->errorForbidden('user_exist');
            }
        }

        $data['password'] = Hash::make(str_random());
//        $data['email'] = preg_replace('/[^0-9]*/','', $data['phone']).'@village.dev';

        /** @var UserRegistration $userRegistration */
        $userRegistration = app('Modules\User\Services\UserRegistration');

        $token = DB::transaction(function() use ($userRegistration, $data) {
            $userRegistration->register($data);
            return Token::create([
                'type'  => Token::TYPE_REGISTRATION,
                'phone' => $data['phone'],
            ]);
        });

        return $this->response->withItem($token, new TokenTransformer);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function registrationConfirm(Request $request)
    {
        $data = $request::only(['session', 'code', 'first_name', 'last_name', 'password', 'password_confirmation']);

        $validator = Validator::make($data, [
            // token
            'session' => 'required',
            'code'    => 'required',
            // user
            'first_name' => 'required',
            'last_name' => 'required',
//            'email' => 'required|unique:users|email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors());
        }

        $token = Token::findOneByTypeAndSessionAndCode(Token::TYPE_REGISTRATION, $data['session'], $data['code']);
        if (!$token) {
            return $this->response->errorNotFound('token_not_found');
        }
        unset($data['session'], $data['code']);

        $password = $data['password'];
        $data['password'] = Hash::make($data['password']);
//        $data['email'] = $token['phone'].'@village.dev';

        $user = User::where(['phone' => $token['phone']])->first();
        if (!$user) {
            return $this->response->errorNotFound('user_not_found');
        }

        $activation = Activation::exists($user);
        if (!$activation) {
            $activation = Activation::create($user);
        }

        DB::transaction(function() use ($user, $data, $token, $activation) {
            $user->update($data);
            Activation::complete($user, $activation->getCode());
            $token->delete();
        });

        $request::replace(['phone' => $token['phone'], 'password' => $password]);

        return (new AuthController($this->response))->auth($request);
    }

    /**
     * Reset password
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function reset(Request $request)
    {
        $data = $request::only(['session', 'code', 'password', 'password_confirmation']);

        $validator = Validator::make($data, [
            // token
            'session' => 'required',
            'code'    => 'required',
            // user
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors());
        }

        $token = Token::findOneByTypeAndSessionAndCode(Token::TYPE_RESET_PASSWORD, $data['session'], $data['code']);
        if (!$token) {
            return $this->response->errorNotFound('token_not_found');
        }
        unset($data['session'], $data['code']);

        $user = User::where(['phone' => $token['phone']])->first();
        /** @var $user User */
        if (!$user) {
            return $this->response->errorNotFound('user_not_found');
        }

        if (!$user->isActivated()) {
            return $this->response->errorForbidden('user_not_activated');
        }

        $password = $data['password'];
        $data['password'] = Hash::make($data['password']);

        DB::transaction(function() use ($user, $token, $data) {
            $user->update(['phone' => $token['phone'], 'password' => $data['password']]);
            $token->delete();
        });

        $request::replace(['phone' => $token['phone'], 'password' => $password]);

        return (new AuthController($this->response))->auth($request);
    }

//    /**
//     * Get all users
//     *
//     * @return Response
//     */
//    public function index()
//    {
//        $users = User::all()->load(['building']);
//
//        return $this->response->withCollection($users, new UserTransformer);
//    }
//    /**
//     * Get a single user
//     *
//     * @param $userId
//     * @return Response
//     */
//    public function show($userId)
//    {
//        $user = User::find($userId);
//        if(!$user){
//            return $this->response->errorNotFound('Not Found');
//        }
//
//        return $this->response->withItem($user, new UserTransformer);
//    }

//    /**
//     * Store a user
//     *
//     * @return Response
//     */
//    public function store()
//    {
//        $input = Input::only('email', 'name', 'password');
//        $user = User::create($input);
//
//        return $this->response->withItem($user, new UserTransformer);
//    }
//
//    /**
//     * Update a user
//     *
//     * @param $userId
//     * @return Response
//     */
//    public function update($userId)
//    {
//        $input = Input::only('email', 'name', 'password');
//        $user = User::find($userId);
//        if(!$user){
//            return $this->response->errorNotFound('Not Found');
//        }
//
//        $user->update($input);
//
//        return $this->response->withItem($user, new UserTransformer);
//    }
//    /**
//     * Delete a user
//     *
//     * @param $userId
//     * @return Response
//     */
//    public function destroy($userId)
//    {
//        $user = User::find($userId);
//        if(!$user){
//            return $this->response->errorNotFound('Not Found');
//        }
//
//        // Remove all book relationships
////        $user->books()->sync([]);
//        $user->delete();
//
//        return Response::json([
//            'success' => true
//        ]);
//    }
}