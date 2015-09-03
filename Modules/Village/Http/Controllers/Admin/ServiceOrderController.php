<?php namespace Modules\Village\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Village\Entities\ServiceOrder;
use Modules\Village\Repositories\ServiceOrderRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ServiceOrderController extends AdminBaseController
{
    /**
     * @var ServiceOrderRepository
     */
    private $serviceorder;

    public function __construct(ServiceOrderRepository $serviceorder)
    {
        parent::__construct();

        $this->serviceorder = $serviceorder;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$serviceorders = $this->serviceorder->all();

        return view('village::admin.serviceorders.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('village::admin.serviceorders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->serviceorder->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('village::serviceorders.title.serviceorders')]));

        return redirect()->route('admin.village.serviceorder.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ServiceOrder $serviceorder
     * @return Response
     */
    public function edit(ServiceOrder $serviceorder)
    {
        return view('village::admin.serviceorders.edit', compact('serviceorder'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ServiceOrder $serviceorder
     * @param  Request $request
     * @return Response
     */
    public function update(ServiceOrder $serviceorder, Request $request)
    {
        $this->serviceorder->update($serviceorder, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('village::serviceorders.title.serviceorders')]));

        return redirect()->route('admin.village.serviceorder.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ServiceOrder $serviceorder
     * @return Response
     */
    public function destroy(ServiceOrder $serviceorder)
    {
        $this->serviceorder->destroy($serviceorder);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('village::serviceorders.title.serviceorders')]));

        return redirect()->route('admin.village.serviceorder.index');
    }
}
