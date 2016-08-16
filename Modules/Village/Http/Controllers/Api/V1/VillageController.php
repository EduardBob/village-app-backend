<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use EllipseSynergie\ApiResponse\Contracts\Response;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Request;
use Validator;

class VillageController extends ApiController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function request(Request $request)
    {
        $data = $request::only(['phone', 'full_name', 'position', 'address']);
        $siteName = \Setting::get('core::site-name', \App::getLocale());
        $data['site-name'] = $siteName;

        $validator = Validator::make($data, [
            'phone' => 'required|regex:'.config('village.user.phone.regex'),
            'full_name' => 'required|min:3',
            'position' => 'required|in:'.implode(',', config('village.village.positions')),
            'address' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors());
        }

        Mail::queue('village::emails.request', ['data' => $data],
            function (Message $m) use ($siteName) {
                $toEmails = explode(',', \Setting::get('village::village-request-send-to-emails'));
                $toEmails = array_map('trim', $toEmails);
                $m->to($toEmails)
                    ->subject(trans('village::villages.emails.request.subject', ['site-name' => $siteName]))
                ;
            }
        );

        $this->response->setStatusCode(201);
        return $this->response->withArray([]);
    }

    /**
     * To be a partner request
     *
     * @param Request $request
     *
     * @return Response
     */
    public function partnerRequest(Request $request)
    {
        $data = $request::only(['company_name', 'full_name', 'phone']);

        $validator = Validator::make($data, [
            'company_name' => 'required|min:2|max:255',
            'full_name' => 'required|min:3|max:255',
            'phone' => 'required|regex:'.config('village.user.phone.regex'),
        ]);

        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors());
        }

        Mail::queue('village::emails.partner-request', ['data' => $data],
            function (Message $m) {
                $toEmails = explode(',', \Setting::get('village::village-request-send-to-emails'));
                $toEmails = array_map('trim', $toEmails);
                $siteName = \Setting::get('core::site-name', \App::getLocale());
                $m->to($toEmails)
                  ->subject(trans('village::villages.emails.partner_request.subject', ['site-name' => $siteName]))
                ;
            }
        );

        $this->response->setStatusCode(201);
        return $this->response->withArray([]);
    }
}