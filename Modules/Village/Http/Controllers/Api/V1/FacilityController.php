<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Carbon\Carbon;
use DB;
use Hash;
use Illuminate\Support\Facades\Mail;
use Modules\Village\Entities\AbstractFacility;
use Modules\Village\Entities\Building;
use Modules\Village\Entities\Sms;
use Modules\Village\Entities\Token;
use Modules\Village\Entities\User;
use Modules\Village\Entities\Village;
use Modules\Village\Packback\Transformer\TokenTransformer;
use Modules\Village\Repositories\Eloquent\EloquentUserRoleRepository;
use Request;
use Validator;


class FacilityController extends VillageController
{
    var $user;
    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function registration(Request $request)
    {
        $data      = $request::only(['phone', 'full_name', 'email', 'address', 'type', 'name']);
        $types     = AbstractFacility::getTypes();
        $types     = implode(',', $types);
        $validator = Validator::make($data, [
          'phone'     => 'required|regex:' . config('village.user.phone.regex') . '|unique:users,phone',
          'full_name' => 'required',
          'email'     => 'unique:users|email',
          'name'      => 'required|unique:village__villages,name|max:255', // TODO make facility name not unique.
          'type'      => 'required:in' . $types
        ]);
        $userNames = $this->getUserNames($data['full_name']);
        $firstName = $userNames['first_name'];
        $lastName = $userNames['last_name'];
        $data['email'] = urldecode($data['email']);


        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors());
        }
        try {
            $user = new User();
            DB::transaction(function () use ($data, $firstName, $lastName, &$user) {
                // Step 1 create village.
                $paidUntil = (new Carbon())->addDays(30)->format('Y-m-d H:i:00');
                $facilityAttributes = ['name'        => $data['name'],
                                       'type'        => $data['type'],
                                       'active'      => 1,
                                       'payed_until' => $paidUntil,
                                       'packet'      => 1,
                                       'balance'     => 0
                ];
                $facility = (new Village)->create($facilityAttributes);
                // Step 2 create building attached to facility.
                if ($facility) {
                    $buildingAttributes = ['address' => $facility->name, 'village_id' => $facility->id];
                    $building           = (new Building())->create($buildingAttributes);
                    // Step 3 create user.
                    if ($building) {
                        $userAttributes   = [
                          'first_name'  => $firstName,
                          'last_name'   => $lastName,
                          'phone'       => $data['phone'],
                          'email'       => $data['email'],
                          'building_id' => $building->id,
                          'village_id'  => $facility->id,
                          'password'    => Hash::make(str_random())
                        ];
                        $userRegistration = app('Modules\User\Services\UserRegistration');
                        $user             = $userRegistration->register($userAttributes);
                        $role             = (new EloquentUserRoleRepository())->findBySlug('village-admin');
                        $user->roles()->sync([$role->id]);
                        $this->generateRegistrationTokenAndSendSms($user);
                        // Step 4 facility admin setup.
                        $facility->main_admin_id = $user->id;
                        $facility->save();
                    }
                }
            });
            $this->response->setStatusCode(201);
            $success            = [];
            $success['message'] = trans('village::villages.messages.created');
            $this->registrationNotify($user);
            return $this->response->withArray($success);

        } catch (\Exception $e) {
            // return $this->response->errorInternalError('facility_registration_error');
            // More information for debugging.
            return $this->response->withError($e->getMessage(), 500);
        }
    }

    private function registrationNotify(User $user)
    {
        $facilityName = $user->village->name;
        $messageText = "Здравствуйте! \r\n Конфигурация сервиса Консьерж для объекта $facilityName создана.";
        $token = (new Token)->findOneByTypeAndPhone(Token::TYPE_REGISTRATION, $user->phone);
        $messageText .= "\r\n Код активации: ".$token->code;
        Mail::raw($messageText, function ($message) use ($user, $facilityName) {
            $message->to($user->email);
            $message->subject("Ваш Консьерж для ".$facilityName." создана.");
        });
        $globalAdministrators = User::whereHas('roles', function ($query) {
            $query->where('slug', 'admin');
        })->get();
        $adminEmails = [];
        foreach ($globalAdministrators as $admin) {
            $adminEmails[] = $admin->email;
        }
        if (count($adminEmails)) {
            $adminMessage = "Пользователь $user->email запросил тестовый доступ к сервису Консьерж $facilityName";
            $adminMessage .= "\r\n Дата активации аккаунта: " . date('d.m.Y');
            $adminMessage .= "\r\n Дата завершения тестового периода: " . date('d.m.Y', strtotime('+ 30 days'));
            Mail::raw($adminMessage, function ($message) use ($user, $adminEmails, $facilityName) {
                $message->to($adminEmails);
                $message->subject("Новая тестовая конфигурация для " . $facilityName . " создана.");
            });
        }
    }

    private function getUserNames($name)
    {
        $name = trim($name);
        $name = mb_ereg_replace("/[^A-Za-zА-Яа-я0-9 ]/", '', $name);
        $parts = explode(' ', $name);
        if (count($parts)) {
            $returnName = [];
            $returnName['first_name']  = $parts[0];
            $returnName['middle_name'] = (isset($parts[2])) ? $parts[1] : '';
            $returnName['last_name']   = (isset($parts[2])) ? $parts[2] : (isset($parts[1]) ? $parts[1] : '');
            return $returnName;
        } else {
            return ['first_name' => $name, 'last_name' => ''];
        }
    }

    private function generateRegistrationTokenAndSendSms(User $user)
    {
        $token = Token::create([
          'type'  => Token::TYPE_REGISTRATION,
          'phone' => $user->phone,
        ]);

        $sms = new Sms();
        $sms->village()->associate($user->village_id);
        $sms
          ->setPhone($user->phone)
          ->setText('Код подтверждения регистрации: '.$token->code)
        ;

        if (($response = $this->sendSms($sms)) !== true) {
            return $response;
        }

        return $this->response->withItem($token, new TokenTransformer);
    }
}
