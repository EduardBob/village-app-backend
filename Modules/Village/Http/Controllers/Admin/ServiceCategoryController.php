<?php namespace Modules\Village\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Village\Entities\ServiceCategory;
use Modules\Village\Repositories\ServiceCategoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ServiceCategoryController extends AdminBaseController
{
    /**
     * @var ServiceCategoryRepository
     */
    private $serviceCategory;

    public function __construct(ServiceCategoryRepository $serviceCategory)
    {
        parent::__construct();

        $this->serviceCategory = $serviceCategory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$servicecategories = $this->serviceCategory->all();

        return view('village::admin.servicecategories.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('village::admin.servicecategories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->serviceCategory->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('village::servicecategories.title.servicecategories')]));

        return redirect()->route('admin.village.servicecategory.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ServiceCategory $serviceCategory
     * @return Response
     */
    public function edit(ServiceCategory $serviceCategory)
    {
        return view('village::admin.servicecategories.edit', compact('servicecategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ServiceCategory $serviceCategory
     * @param  Request $request
     * @return Response
     */
    public function update(ServiceCategory $serviceCategory, Request $request)
    {
        $this->serviceCategory->update($serviceCategory, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('village::servicecategories.title.servicecategories')]));

        return redirect()->route('admin.village.servicecategory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ServiceCategory $serviceCategory
     * @return Response
     */
    public function destroy(ServiceCategory $serviceCategory)
    {
        $this->serviceCategory->destroy($serviceCategory);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('village::servicecategories.title.servicecategories')]));

        return redirect()->route('admin.village.servicecategory.index');
    }
}
