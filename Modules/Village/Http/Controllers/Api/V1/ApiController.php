<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Fruitware\ProstorSms\Exception\BadSmsStatusException;
use Fruitware\ProstorSms\Model\SmsInterface;
use Illuminate\Routing\Controller;
use EllipseSynergie\ApiResponse\Contracts\Response;
use Modules\Village\Entities\Sms;
use Modules\Village\Entities\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiController extends Controller
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return User
     */
    protected function user()
    {
        return JWTAuth::parseToken()->authenticate();
    }

    /**
     * @param Sms $sms
     *
     * @return true|mixed
     */
    protected function sendSms(Sms $sms)
    {
        try {
            $sms->send($sms);
        }
        catch (BadSmsStatusException $ex) {
            if ($ex->getStatus() == $sms::STATUS_INVALID_MOBILE_PHONE) {
                return $this->response->errorForbidden('sms_'.$sms::STATUS_INVALID_MOBILE_PHONE);
            }
            else {
                return $this->response->errorForbidden('sms_internal_error');
            }
        }
    }
}