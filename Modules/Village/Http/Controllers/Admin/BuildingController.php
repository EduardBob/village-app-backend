<?php namespace Modules\Village\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Village\Entities\Building;
use Modules\Village\Repositories\BuildingRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

use Validator;

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
        $buildings = $this->building->all()->sortBy('address');

        return view('village::admin.buildings.index', compact('buildings'));
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
        $validator = $this->validate($request->all());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $nextId = $this->building->all()->max('id') + 1;
        $code = $this->getCode();
        $record = $this->checkRecord($code);

        while ($record !== null) {
            $code = $this->getCode();
            $record = $this->checkRecord($code);
        }

        $this->building->create(array_merge($request->all(), ['code' => $code]));

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
        $validator = $this->validate($request->all());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
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


    static function validate($data) {
        return Validator::make($data, [
            'address' => 'required'
        ]);
    }

    static function getCode($length = 7) {
        return substr( md5(rand()), 0, $length);
    }

    public function checkRecord($code) {
        return $this->building->all()->where('code', $code)->first();
    }
}
