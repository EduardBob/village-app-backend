<?php namespace Modules\Village\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Village\Entities\Option;
use Modules\Village\Repositories\OptionRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class OptionController extends AdminBaseController
{
    /**
     * @var OptionRepository
     */
    private $option;

    public function __construct(OptionRepository $option)
    {
        parent::__construct();

        $this->option = $option;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$options = $this->option->all();

        return view('village::admin.options.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('village::admin.options.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->option->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('village::options.title.options')]));

        return redirect()->route('admin.village.option.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Option $option
     * @return Response
     */
    public function edit(Option $option)
    {
        return view('village::admin.options.edit', compact('option'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Option $option
     * @param  Request $request
     * @return Response
     */
    public function update(Option $option, Request $request)
    {
        $this->option->update($option, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('village::options.title.options')]));

        return redirect()->route('admin.village.option.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Option $option
     * @return Response
     */
    public function destroy(Option $option)
    {
        $this->option->destroy($option);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('village::options.title.options')]));

        return redirect()->route('admin.village.option.index');
    }
}
