<?php namespace Modules\Village\Http\Controllers\Admin;

use Modules\Village\Entities\Building;
use Modules\Village\Repositories\BuildingRepository;

use Validator;

class BuildingController extends AdminController
{
    /**
     * @param BuildingRepository $building
     */
    public function __construct(BuildingRepository $building)
    {
        parent::__construct($building);
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'buildings';
    }

    /**
     * @param array    $data
     * @param Building $building
     *
     * @return Validator
     */
    static function validate(array $data, Building $building = null)
    {
        $buildingId = $building ? $building->id : '';

        return Validator::make($data, [
            'address' => "required|max:255|unique:village__buildings,address,{$buildingId}",
        ]);
    }

    /**
     * @param $code
     *
     * @return mixed
     */
    public function checkRecord($code)
    {
        return $this->getRepository()->all()->where('code', $code)->first();
    }
}
