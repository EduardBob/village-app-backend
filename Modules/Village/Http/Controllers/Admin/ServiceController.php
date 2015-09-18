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
        parent::__construct($service);
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'services';
    }

    /**
     * @param Model   $model
     * @param Request $request
     */
    public function preStore(Model $model, Request $request)
    {
        /** @var Service $model */
        $category = ServiceCategory::find($request['category']);
        $model->category()->associate($category);
    }

    /**
     * @param Model   $model
     * @param Request $request
     */
    public function preUpdate(Model $model, Request $request)
    {
        $this->preStore($model, $request);
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
            'title' => "required|max:255|unique:village__services,title,{$serviceId}",
            'category' => 'required|exists:village__service_categories,id',
            'price' => 'required|numeric|min:1'
        ]);
    }
}
