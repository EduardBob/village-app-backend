<?php
namespace Modules\Village\Entities;

interface FacilityInterface
{

    const TYPE_BUSINESS = 'business';
    const TYPE_SHOPPING = 'shopping';
    const TYPE_COTTAGE = 'cottage';
    const TYPE_APARTMENT = 'apartment';

    /**
     * @return array
     */
    public static function getTypes();

}
