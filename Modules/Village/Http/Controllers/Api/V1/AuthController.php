<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Modules\Village\Exceptions\UserNotActivatedException;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Request;

class AuthController extends ApiController
{
    /**
     * @param Request $request
     *
     * @return string
     */
    public function auth(Request $request)
    {
        // grab credentials from the request
        $credentials = $request::only('phone', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->response->errorUnauthorized('invalid_credentials');
            }
        }
        catch (UserNotActivatedException $e) {
            return $this->response->errorForbidden('user_not_activated');
        }
        catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return $this->response->errorInternalError('could_not_create_token');
        }

        // all good so return the token
        return $this->response->withArray(['data' => ['token' => $token]]);
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    public function refresh(Request $request)
    {
        $token = JWTAuth::getToken();

        $refresh = JWTAuth::refresh($token);

        // all good so return the token
        return $this->response->withArray(compact('refresh'));
    }
}