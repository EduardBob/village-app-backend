<?php namespace Modules\Village\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Village\Entities\User;
use Modules\Village\Repositories\UserRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class UserController extends AdminBaseController
{
    /**
     * @var UserRepository
     */
    private $user;

    public function __construct(UserRepository $user)
    {
        parent::__construct();

        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$users = $this->user->all();

        return view('village::admin.users.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('village::admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->user->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('village::users.title.users')]));

        return redirect()->route('admin.village.user.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return Response
     */
    public function edit(User $user)
    {
        return view('village::admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  User $user
     * @param  Request $request
     * @return Response
     */
    public function update(User $user, Request $request)
    {
        $this->user->update($user, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('village::users.title.users')]));

        return redirect()->route('admin.village.user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        $this->user->destroy($user);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('village::users.title.users')]));

        return redirect()->route('admin.village.user.index');
    }
}
