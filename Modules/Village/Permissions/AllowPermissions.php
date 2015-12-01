<?php

namespace Modules\Village\Permissions;

use Cartalyst\Sentinel\Permissions\PermissionsInterface;
use Cartalyst\Sentinel\Permissions\PermissionsTrait;

class AllowPermissions implements PermissionsInterface
{
    use PermissionsTrait;

    /**
     * {@inheritDoc}
     */
    protected function createPreparedPermissions()
    {
        $prepared = [];

        // права группы
        if (! empty($this->secondaryPermissions)) {
            foreach ($this->secondaryPermissions as $permissions) {
                $this->preparePermissions($prepared, $permissions);
            }
        }

        // игнор permissions конкретного пользователя
//        if (! empty($this->permissions)) {
//            $this->preparePermissions($prepared, $this->permissions);
//        }

        return $prepared;
    }

    /**
     * Does the heavy lifting of preparing permissions.
     *
     * @param  array  $prepared
     * @param  array  $permissions
     * @return void
     */
    protected function preparePermissions(array &$prepared, array $permissions)
    {
        foreach ($permissions as $keys => $value) {
            foreach ($this->extractClassPermissions($keys) as $key) {
                // If the value is not in the array, we're opting in
                if (! array_key_exists($key, $prepared)) {
                    $prepared[$key] = $value;

                    continue;
                }

                // Если хоть где-то стоит true, то разрешаем
                if ($value === true) {
                    $prepared[$key] = $value;
                }
            }
        }
    }
}
