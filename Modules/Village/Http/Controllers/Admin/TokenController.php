<?php namespace Modules\Village\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Village\Entities\Token;
use Modules\Village\Repositories\TokenRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class TokenController extends AdminBaseController
{
    /**
     * @var TokenRepository
     */
    private $token;

    public function __construct(TokenRepository $token)
    {
        parent::__construct();

        $this->token = $token;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$tokens = $this->token->all();

        return view('village::admin.tokens.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('village::admin.tokens.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->token->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('village::tokens.title.tokens')]));

        return redirect()->route('admin.village.token.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Token $token
     * @return Response
     */
    public function edit(Token $token)
    {
        return view('village::admin.tokens.edit', compact('token'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Token $token
     * @param  Request $request
     * @return Response
     */
    public function update(Token $token, Request $request)
    {
        $this->token->update($token, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('village::tokens.title.tokens')]));

        return redirect()->route('admin.village.token.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Token $token
     * @return Response
     */
    public function destroy(Token $token)
    {
        $this->token->destroy($token);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('village::tokens.title.tokens')]));

        return redirect()->route('admin.village.token.index');
    }
}
