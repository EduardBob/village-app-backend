<?php

namespace Modules\Village\Packback\Transformer;

use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use Modules\Village\Entities\User;

class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['building'];

    /**
     * List of resources to automatically include
     *
     * @var  array
     */
    protected $defaultIncludes = ['building'];

    /**
     * Turn user object into generic array
     *
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' =>  $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
//            'email' => $user->email,
            'phone' => $user->phone,
            'activated' => \Activation::completed($user) ? true : false
        ];
    }

    /**
     * Include building in user
     *
     * @param User $user
     * @return Item
     */
    public function includeBuilding(User $user)
    {
        if ($user->building) {
            return $this->item($user->building, new BuildingTransformer);
        }
    }
}