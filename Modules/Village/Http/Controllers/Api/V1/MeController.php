<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Modules\Village\Packback\Transformer\UserTransformer;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use JWTAuth;

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
}