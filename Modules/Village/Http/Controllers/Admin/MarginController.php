<?php namespace Modules\Village\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Village\Entities\Margin;
use Modules\Village\Repositories\MarginRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class MarginController extends AdminBaseController
{
    /**
     * @var MarginRepository
     */
    private $margin;

    public function __construct(MarginRepository $margin)
    {
        parent::__construct();

        $this->margin = $margin;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$margins = $this->margin->all();

        return view('village::admin.margins.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('village::admin.margins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->margin->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('village::margins.title.margins')]));

        return redirect()->route('admin.village.margin.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Margin $margin
     * @return Response
     */
    public function edit(Margin $margin)
    {
        return view('village::admin.margins.edit', compact('margin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Margin $margin
     * @param  Request $request
     * @return Response
     */
    public function update(Margin $margin, Request $request)
    {
        $this->margin->update($margin, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('village::margins.title.margins')]));

        return redirect()->route('admin.village.margin.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Margin $margin
     * @return Response
     */
    public function destroy(Margin $margin)
    {
        $this->margin->destroy($margin);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('village::margins.title.margins')]));

        return redirect()->route('admin.village.margin.index');
    }
}
