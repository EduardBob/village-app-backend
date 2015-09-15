<?php namespace Modules\Village\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Village\Entities\Product;
use Modules\Village\Repositories\ProductRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

use Modules\Village\Entities\ProductCategory;
use Validator;

class ProductController extends AdminBaseController
{
    /**
     * @var ProductRepository
     */
    private $product;

    public function __construct(ProductRepository $product)
    {
        parent::__construct();

        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $products = $this->product->all();

        return view('village::admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('village::admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $category = ProductCategory::find($request['category']);
        $validator = $this->validate($request->all());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $item = $this->product->create($request->all());
        $item->category()->associate($category);
        $item->save();

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('village::products.title.products')]));

        return redirect()->route('admin.village.product.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Product $product
     * @return Response
     */
    public function edit(Product $product)
    {
        return view('village::admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Product $product
     * @param  Request $request
     * @return Response
     */
    public function update(Product $product, Request $request)
    {
        $category = ProductCategory::find($request['category']);
        $validator = $this->validate($request->all());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $item = $this->product->update($product, $request->all());
        $item->category()->associate($category);
        $item->save();

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('village::products.title.products')]));

        return redirect()->route('admin.village.product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product $product
     * @return Response
     */
    public function destroy(Product $product)
    {
        $this->product->destroy($product);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('village::products.title.products')]));

        return redirect()->route('admin.village.product.index');
    }

    static function validate($data) 
    {
        return Validator::make($data, [
            'title' => 'required|string',
            'price' => 'required|numeric'
        ]);
    }
}
