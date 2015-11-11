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
     * Get villages list
     *
     * @param Request $request
     *
     * @return Response
     */
    public function request(Request $request)
    {
        $data = $request::only(['phone', 'full_name', 'position', 'address']);

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
            function (Message $m) {
                $toEmails = explode(',', \Setting::get('village::village-request-send-to-emails'));
                $siteName = \Setting::get('core::site-name', \App::getLocale());
                $m->to($toEmails)
                    ->subject(trans('village::villages.emails.request.subject', ['site-name' => $siteName]))
                ;
            }
        );

        $this->response->setStatusCode(201);
        return $this->response->withArray([]);
    }
}