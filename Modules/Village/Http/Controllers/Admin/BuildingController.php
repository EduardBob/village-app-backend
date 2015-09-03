<?php namespace Modules\Village\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Village\Entities\Building;
use Modules\Village\Repositories\BuildingRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class BuildingController extends AdminBaseController
{
    /**
     * @var BuildingRepository
     */
    private $building;

    public function __construct(BuildingRepository $building)
    {
        parent::__construct();

        $this->building = $building;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$buildings = $this->building->all();

        return view('village::admin.buildings.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('village::admin.buildings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->building->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('village::buildings.title.buildings')]));

        return redirect()->route('admin.village.building.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Building $building
     * @return Response
     */
    public function edit(Building $building)
    {
        return view('village::admin.buildings.edit', compact('building'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Building $building
     * @param  Request $request
     * @return Response
     */
    public function update(Building $building, Request $request)
    {
        $this->building->update($building, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('village::buildings.title.buildings')]));

        return redirect()->route('admin.village.building.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Building $building
     * @return Response
     */
    public function destroy(Building $building)
    {
        $this->building->destroy($building);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('village::buildings.title.buildings')]));

        return redirect()->route('admin.village.building.index');
    }
}
