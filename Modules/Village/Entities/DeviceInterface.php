<?php
namespace Modules\Village\Entities;

interface DeviceInterface
{

    const TYPE_IOS = 'ios';
    const TYPE_ANDROID = 'gcm';

    /**
     * @return array
     */
    public static function getTypes();
}
