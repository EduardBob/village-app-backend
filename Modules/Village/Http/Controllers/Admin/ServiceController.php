<?php namespace Modules\Village\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Village\Entities\Service;
use Modules\Village\Repositories\ServiceRepository;

use Modules\Village\Entities\ServiceCategory;
use Validator;

class ServiceController extends AdminController
{
    /**
     * @param ServiceRepository $service
     */
    public function __construct(ServiceRepository $service)
    {
        parent::__construct($service, Service::class);
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'services';
    }

    /**
     * @param array   $data
     * @param Service $service
     *
     * @return Validator
     */
    static function validate(array $data, Service $service = null)
    {
        $serviceId = $service ? $service->id : '';

        return Validator::make($data, [
            'category_id' => 'required|exists:village__service_categories,id',
            'title' => "required|max:255|unique:village__services,title,{$serviceId}",
            'price' => 'required|numeric|min:1',
            'active' => "required|boolean",
        ]);
    }
}
