<?php namespace Modules\Village\Http\Controllers\Admin;


use Modules\Village\Entities\Village;
use Modules\Village\Entities\User;
use Modules\Village\Entities\Product;
use Modules\Village\Entities\Service;


abstract class AbstractGoodsController extends AdminController
{

    /**
     * @param Village $village
     *
     * @return \Illuminate\Support\Collection
     */
    public function getExecutors(Village $village = null)
    {
        if (!$village) {
            return [];
        }

        $role = $this->roleRepository->findBySlug('executor');
        $userIds = [];
        foreach ($role->users as $user) {
            $userIds[] = $user->id;
        }

        $users = User
          ::select(['users.id', 'last_name', 'first_name'])
          ->where('village_id', $village->id)
          ->whereIn('id', $userIds)
          ->get()
        ;

        // Getting additional users, globla administrator can attach users in role "executor" to additional villages.
        // Users to Villages in this case are related via pivot table.
        if ($village->additionalUsers) {
            $usersIdsAdditional = $village->additionalUsers()->select(['user_id'])->lists('user_id')->toArray();
            if (!empty($usersIdsAdditional)) {
                $usersAdditional = User
                  ::select(['id', 'last_name', 'first_name'])
                  ->whereIn('id', $usersIdsAdditional)
                  ->get();
                $users = $users->merge($usersAdditional);
            }
        }

        $list = [];
        foreach ($users as $user) {
            $list[$user->id] = $user->present()->fullname();
        }

        return $list;
    }

}
