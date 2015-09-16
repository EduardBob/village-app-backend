<?php namespace Modules\Village\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Village\Entities\ProductOrder;
use Modules\Village\Repositories\ProductOrderRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

use Modules\Village\Entities\Product;
use Modules\User\Entities\Sentinel\User;
use Carbon\Carbon;
use Validator;

class ProductOrderController extends AdminBaseController
{
    /**
     * @var ProductOrderRepository
     */
    private $productOrder;

    public function __construct(ProductOrderRepository $productOrder)
    {
        parent::__construct();

        $this->productOrder = $productOrder;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $productOrders = $this->productOrder->all();

        return view('village::admin.productorders.index', compact('productOrders'));
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
        $product = Product::find($request['product']);
        $user = User::find($request['profile']);
        $request['perform_at'] = Carbon::parse($request['perform_at']);

        $validator = $this->validate($request->all());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $item = $this->productOrder->create($request->all());

        $item->product()->associate($product);
        $item->profile()->associate($user->profile());
        $item->save();

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('village::productorders.title.productorders')]));

        return redirect()->route('admin.village.productorder.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ProductOrder $productOrder
     * @return Response
     */
    public function edit(ProductOrder $productOrder)
    {
        return view('village::admin.productorders.edit', compact('productOrder'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductOrder $productOrder
     * @param  Request $request
     * @return Response
     */
    public function update(ProductOrder $productOrder, Request $request)
    {
        $product = Product::find($request['product']);
        $user = User::find($request['profile']);
        $request['perform_at'] = Carbon::parse($request['perform_at']);
        $request['status'] = config('village.order.statuses')[$request['status']];

        $validator = $this->validate($request->all());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $item = $this->productOrder->update($productOrder, $request->all());
        
        $item->product()->associate($product);
        $item->profile()->associate($user->profile());
        $item->save();

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('village::productorders.title.productorders')]));

        return redirect()->route('admin.village.productorder.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ProductOrder $productOrder
     * @return Response
     */
    public function destroy(ProductOrder $productOrder)
    {
        $this->productOrder->destroy($productOrder);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('village::productorders.title.productorders')]));

        return redirect()->route('admin.village.productorder.index');
    }

    static function validate($data) 
    {
        return Validator::make($data, [
            'perform_at' => 'required|date|after:yesterday',
            'status' => 'sometimes|required',
            'comment' => 'sometimes|required|string',
            'decline_reason' => 'sometimes|required_if:status,rejected|string',
            'profile' => 'required',
            'product' => 'required',
            'quantity' => 'required|numeric'
        ]);
    }
}
