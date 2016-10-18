<?php
namespace Modules\Village\Entities;

interface FacilityInterface
{

    const FACILITY_BUSINESS = 'Business center';
    const FACILITY_SHOPPING = 'Shopping center';
    const FACILITY_COTTAGE = 'Cottage village';
    const FACILITY_APARTMENT = 'Apartment complex';

    /**
     * @return array
     */
    public static function getTypes();

}
