<?php namespace App\Observers;

use Modules\Village\Entities\Profile;
use Modules\Village\Entities\Building;
use Request;

class UserObserver {

    public function created($user)
    {
        $profile = (new Profile);
        $data = array_only(Request::all(), ['phone', 'building_id']);

        $profile->createItem($data, $user->id);
    }

    // Updated method
    public function handle($user) {

    	$user = $user->user;
    	$data = array_only(Request::all(), ['phone', 'building_id']);

    	$profile = (new Profile);
    	$profile->updateItem($user, $data);
    }
}