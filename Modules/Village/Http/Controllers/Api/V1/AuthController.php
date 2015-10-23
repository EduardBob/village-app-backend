<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use Modules\Village\Exceptions\UserNotActivatedException;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Request;
use Tymon\JWTAuth\Providers\Auth\AuthInterface;

class AuthController extends ApiController
{
    /**
     * @param Request $request
     *
     * @return string
     */
    public function auth(Request $request, AuthInterface $auth)
    {
        // grab credentials from the request
        $credentials = $request::only('phone', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->response->errorUnauthorized('invalid_credentials');
            }
        }
        catch (JWTException $e) {
            switch ($e->getStatusCode()) {
                case 400:
                    return $this->response->errorWrongArgs($e->getMessage());
                case 401:
                    return $this->response->errorUnauthorized($e->getMessage());
                case 403:
                    return $this->response->errorForbidden($e->getMessage());
                default:
                    $this->response->setStatusCode($e->getStatusCode());
                    return $this->response->withError($e->getMessage(), $e->getCode());
            }
        }

        // all good so return the token
        return $this->response->withArray(['data' => ['token' => $token]]);
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    public function refresh(Request $request, AuthInterface $auth)
    {
        $token = JWTAuth::getToken();

        $refresh = JWTAuth::refresh($token);

        // all good so return the token
        return $this->response->withArray(['data' => ['token' => $refresh]]);
    }
}