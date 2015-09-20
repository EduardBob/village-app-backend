<?php namespace Modules\Village\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Core\Repositories\BaseRepository;

use Validator;

abstract class AdminController extends AdminBaseController
{
    /**
     * @var BaseRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $modelClass;

    /**
     * @param BaseRepository $repository
     * @param string         $modelClass
     */
    public function __construct(BaseRepository $repository, $modelClass = null)
    {
        parent::__construct();

        $this->repository = $repository;
        $this->modelClass = $modelClass;
    }

    /**
     * @return string
     */
    abstract public function getViewName();

    /**
     * @return BaseRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @return string
     */
    public function getTransName()
    {
        return $this->getViewName();
    }

	/**
     * @return string
     */
    public function getModule()
    {
        return strtolower(explode('\\', static::class)[1]);
    }

    /**
     * @return string
     */
    public function getClass()
    {
        $a = explode('\\', static::class);
        return strtr(strtolower(array_pop($a)), ['controller' => '']);
    }

    /**
     * @param string $action
     *
     * @return string
     */
    public function getRoute($action)
    {
        return 'admin.'.$this->getModule().'.'.$this->getClass().'.'.$action;
    }

    /**
     * @param string $action
     * @param string $view
     *
     * @return string
     */
    public function getView($action, $view = '')
    {
        $view = $view ? $view : $this->getViewName();
        $modelView = $this->getModule().'::admin.'.$view.'.'.$action;

        return view()->exists($modelView) ? $modelView : $this->getModule().'::admin.admin.'.$action;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function mergeViewData(array $data)
    {
        return array_merge([
            'admin'  => $this,
            'currentLocale' => locale()
        ], $data);
    }

    /**
     * @param string $id
     * @param array  $parameters
     * @param string $domain
     * @param string $locale
     *
     * @return string
     */
    public function trans($id = null, $parameters = [], $domain = 'messages', $locale = null)
    {
        return trans($this->getModule().'::'.$this->getTransName().'.'.$id, $parameters, $domain, $locale);
    }

    /**
     * Generate a URL to a named route.
     *
     * @param  string  $name
     * @param  array   $parameters
     * @param  bool    $absolute
     * @param  \Illuminate\Routing\Route  $route
     * @return string
     */
    public function route($name, $parameters = [], $absolute = true, $route = null)
    {
        $name = $this->getRoute($name);

        return route($name, $parameters, $absolute, $route);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $collection = $this->getRepository()->all();

        return view($this->getView('index'), $this->mergeViewData(compact('collection')));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view($this->getView('create'), $this->mergeViewData([]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = $this->validate($request->all());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $model = new $this->modelClass();
        $model->fill($request->all());
        $this->preStore($model, $request);
        $model->save();

        flash()->success(trans('core::core.messages.resource created', ['name' => $this->trans('title.model')]));

        return redirect()->route($this->getRoute('index'));
    }

    /**
     * @param Model   $model
     * @param Request $request
     */
    public function preStore(Model $model, Request $request)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Model $model
     * @return \Illuminate\View\View
     */
    public function edit(Model $model)
    {
        return view($this->getView('edit'), $this->mergeViewData(compact('model')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Model   $model
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Model $model, Request $request)
    {
        $validator = $this->validate($request->all(), $model);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $model = $this->getRepository()->update($model, $request->all());
        $this->preUpdate($model, $request);
        $model->save();

        flash()->success(trans('core::core.messages.resource updated', ['name' => $this->trans('title.model')]));

        return redirect()->route($this->getRoute('index'));
    }

    /**
     * @param Model   $model
     * @param Request $request
     */
    public function preUpdate(Model $model, Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Model $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Model $model)
    {
        $this->getRepository()->destroy($model);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => $this->trans('title.model')]));

        return redirect()->route($this->getRoute('index'));
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Validation\Validator
     */
    public static function validate(array $data)
    {
    }
}
