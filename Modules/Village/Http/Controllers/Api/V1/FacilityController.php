<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use Hash;
use Modules\Village\Entities\AbstractFacility;
use Modules\Village\Entities\Building;
use Modules\Village\Entities\Village;
use Modules\Village\Entities\User;
use Modules\Village\Repositories\Eloquent\EloquentUserRoleRepository;
use Request;
use Modules\Village\Entities\Sms;
use Modules\User\Services\UserRegistration;
use Modules\Village\Entities\Token;
use Validator;
use Modules\Village\Packback\Transformer\TokenTransformer;

class FacilityController extends VillageController
{
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
        if ($validator->fails()) {
            return $this->response->errorWrongArgs($validator->errors());
        }
        try {
            // Step 1 create village.
            $facilityAttributes = ['name' => $data['name'], 'type' => $data['type'], 'active' => 1];
            $facility           = (new Village)->create($facilityAttributes);
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
                    $sms = $this->generateRegistrationTokenAndSendSms($user);
                    // Step 4 facility admin setup.
                    $facility->main_admin_id = $user->id;
                    $facility->save();
                }
            }

            $this->response->setStatusCode(201);
            $success = [];
            $success['message'] = trans('village::villages.messages.created');
            return $this->response->withArray($success);

        } catch (\Exception $e) {
            // Rollback created data.
            if (isset($building)) {
                $building->forceDelete();
            }
            if (isset($user)) {
                $user->forceDelete();
            }
            if (isset($facility)) {
                $facility->forceDelete();
            }
            return $this->response->errorInternalError('facility_registration_error');
            // More information for debugging.
            //return $this->response->withError($e->getMessage(), 500);
        }
    }

    private function getUserNames($name)
    {
        $name  = trim($name);
        $name = preg_replace("/[^A-Za-z0-9 ]/", '', $name);
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
