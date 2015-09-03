<?php namespace Modules\Village\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Village\Entities\ProductOrder;
use Modules\Village\Repositories\ProductOrderRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ProductOrderController extends AdminBaseController
{
    /**
     * @var ProductOrderRepository
     */
    private $productorder;

    public function __construct(ProductOrderRepository $productorder)
    {
        parent::__construct();

        $this->productorder = $productorder;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$productorders = $this->productorder->all();

        return view('village::admin.productorders.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('village::admin.productorders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->productorder->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('village::productorders.title.productorders')]));

        return redirect()->route('admin.village.productorder.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ProductOrder $productorder
     * @return Response
     */
    public function edit(ProductOrder $productorder)
    {
        return view('village::admin.productorders.edit', compact('productorder'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductOrder $productorder
     * @param  Request $request
     * @return Response
     */
    public function update(ProductOrder $productorder, Request $request)
    {
        $this->productorder->update($productorder, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('village::productorders.title.productorders')]));

        return redirect()->route('admin.village.productorder.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ProductOrder $productorder
     * @return Response
     */
    public function destroy(ProductOrder $productorder)
    {
        $this->productorder->destroy($productorder);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('village::productorders.title.productorders')]));

        return redirect()->route('admin.village.productorder.index');
    }
}
