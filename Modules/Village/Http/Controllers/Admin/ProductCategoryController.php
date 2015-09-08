<?php namespace Modules\Village\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Village\Entities\ProductCategory;
use Modules\Village\Repositories\ProductCategoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ProductCategoryController extends AdminBaseController
{
    /**
     * @var ProductCategoryRepository
     */
    private $productcategory;

    public function __construct(ProductCategoryRepository $productcategory)
    {
        parent::__construct();

        $this->productcategory = $productcategory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$productcategories = $this->productcategory->all();

        return view('village::admin.productcategories.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('village::admin.productcategories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->productcategory->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('village::productcategories.title.productcategories')]));

        return redirect()->route('admin.village.productcategory.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ProductCategory $productcategory
     * @return Response
     */
    public function edit(ProductCategory $productcategory)
    {
        return view('village::admin.productcategories.edit', compact('productcategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductCategory $productcategory
     * @param  Request $request
     * @return Response
     */
    public function update(ProductCategory $productcategory, Request $request)
    {
        $this->productcategory->update($productcategory, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('village::productcategories.title.productcategories')]));

        return redirect()->route('admin.village.productcategory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ProductCategory $productcategory
     * @return Response
     */
    public function destroy(ProductCategory $productcategory)
    {
        $this->productcategory->destroy($productcategory);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('village::productcategories.title.productcategories')]));

        return redirect()->route('admin.village.productcategory.index');
    }
}
