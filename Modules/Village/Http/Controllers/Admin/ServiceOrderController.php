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
    private $serviceOrder;

    public function __construct(ServiceOrderRepository $serviceOrder)
    {
        parent::__construct();

        $this->serviceOrder = $serviceOrder;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$serviceOrders = $this->serviceOrder->all();

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
        $this->serviceOrder->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('village::serviceorders.title.serviceorders')]));

        return redirect()->route('admin.village.serviceorder.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ServiceOrder $serviceOrder
     * @return Response
     */
    public function edit(ServiceOrder $serviceOrder)
    {
        return view('village::admin.serviceorders.edit', compact('serviceorder'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ServiceOrder $serviceOrder
     * @param  Request $request
     * @return Response
     */
    public function update(ServiceOrder $serviceOrder, Request $request)
    {
        $this->serviceOrder->update($serviceOrder, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('village::serviceorders.title.serviceorders')]));

        return redirect()->route('admin.village.serviceorder.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ServiceOrder $serviceOrder
     * @return Response
     */
    public function destroy(ServiceOrder $serviceOrder)
    {
        $this->serviceOrder->destroy($serviceOrder);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('village::serviceorders.title.serviceorders')]));

        return redirect()->route('admin.village.serviceorder.index');
    }
}
