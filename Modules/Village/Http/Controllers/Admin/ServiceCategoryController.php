<?php namespace Modules\Village\Http\Controllers\Admin;

use Modules\Village\Entities\ServiceCategory;
use Modules\Village\Repositories\ServiceCategoryRepository;

use Validator;

class ServiceCategoryController extends AdminController
{
    /**
     * @param ServiceCategoryRepository $serviceCategory
     */
    public function __construct(ServiceCategoryRepository $serviceCategory)
    {
        parent::__construct($serviceCategory);
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'servicecategories';
    }

    /**
     * @param array           $data
     * @param ServiceCategory $serviceCategory
     *
     * @return Validator
     */
    static function validate(array $data, ServiceCategory $serviceCategory = null)
    {
        $serviceCategoryId = $serviceCategory ? $serviceCategory->id : '';

        return Validator::make($data, [
            'title' => "required|max:255|unique:village__service_categories,title,{$serviceCategoryId}",
        ]);
    }
}
