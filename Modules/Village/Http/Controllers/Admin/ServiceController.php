<?php namespace Modules\Village\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Village\Entities\Service;
use Modules\Village\Repositories\ServiceRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

use Modules\Village\Entities\ServiceCategory;
use Validator;

class ServiceController extends AdminBaseController
{
    /**
     * @var ServiceRepository
     */
    private $service;

    public function __construct(ServiceRepository $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $services = $this->service->all();

        return view('village::admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('village::admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $category = ServiceCategory::find($request['category']);
        $validator = $this->validate($request->all());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $item = $this->service->create($request->all());
        $item->category()->associate($category);
        $item->save();

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('village::services.title.services')]));

        return redirect()->route('admin.village.service.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Service $service
     * @return Response
     */
    public function edit(Service $service)
    {
        return view('village::admin.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Service $service
     * @param  Request $request
     * @return Response
     */
    public function update(Service $service, Request $request)
    {
        $category = ServiceCategory::find($request['category']);
        $validator = $this->validate($request->all());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $item = $this->service->update($service, $request->all());
        $item->category()->associate($category);
        $item->save();

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('village::services.title.services')]));

        return redirect()->route('admin.village.service.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Service $service
     * @return Response
     */
    public function destroy(Service $service)
    {
        $this->service->destroy($service);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('village::services.title.services')]));

        return redirect()->route('admin.village.service.index');
    }

    static function validate($data) 
    {
        return Validator::make($data, [
            'title' => 'required|string',
            'category' => 'required|numeric',
            'price' => 'required|numeric'
        ]);
    }
}
