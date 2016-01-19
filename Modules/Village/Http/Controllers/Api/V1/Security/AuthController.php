<?php

namespace Modules\Village\Http\Controllers\Api\V1\Security;

use Modules\Village\Http\Controllers\Api\V1\AuthController as BaseAuthController;
use JWTAuth;
use Request;

class AuthController extends BaseAuthController
{
    /**
     * @param Request $request
     *
     * @return string
     */
    public function auth(Request $request)
    {
        /** @var \Illuminate\Http\JsonResponse $response */
        $response = parent::auth($request);

        if (!$response instanceof \Illuminate\Http\JsonResponse) {
            return $response;
        }

        $token = @$response->getData(true)['data']['token'];
        if (!$token) {
            return $response;
        }

        $user = JWTAuth::authenticate($token);
        if ($user->inRole('security')) {
            return $response;
        }

        return $this->response->errorForbidden('user_is_not_a_security');
    }
}