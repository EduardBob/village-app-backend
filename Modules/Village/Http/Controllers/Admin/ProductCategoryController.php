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
    private $productCategory;

    public function __construct(ProductCategoryRepository $productCategory)
    {
        parent::__construct();

        $this->productCategory = $productCategory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$productcategories = $this->productCategory->all();

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
        $this->productCategory->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('village::productcategories.title.productcategories')]));

        return redirect()->route('admin.village.productcategory.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ProductCategory $productCategory
     * @return Response
     */
    public function edit(ProductCategory $productCategory)
    {
        return view('village::admin.productcategories.edit', compact('productcategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductCategory $productCategory
     * @param  Request $request
     * @return Response
     */
    public function update(ProductCategory $productCategory, Request $request)
    {
        $this->productCategory->update($productCategory, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('village::productcategories.title.productcategories')]));

        return redirect()->route('admin.village.productcategory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ProductCategory $productCategory
     * @return Response
     */
    public function destroy(ProductCategory $productCategory)
    {
        $this->productCategory->destroy($productCategory);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('village::productcategories.title.productcategories')]));

        return redirect()->route('admin.village.productcategory.index');
    }
}
