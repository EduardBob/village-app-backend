<?php namespace Modules\Village\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Core\Contracts\Authentication;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Core\Repositories\BaseRepository;

use Modules\Village\Entities\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use yajra\Datatables\Datatables;
use yajra\Datatables\Engines\EloquentEngine;
use yajra\Datatables\Html\Builder as TableBuilder;

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
     * @var Authentication
     */
    protected $auth;

    /**
     * @var TableBuilder
     */
    protected $builder;

    /**
     * @param BaseRepository $repository
     * @param string         $modelClass
     */
    public function __construct(BaseRepository $repository, $modelClass = null)
    {
        parent::__construct();

        $this->repository = $repository;
        $this->modelClass = $modelClass;

        $this->builder = app('yajra\Datatables\Html\Builder');
        $this->auth = app('Modules\Core\Contracts\Authentication');

        view()->share('currentUser', $this->getCurrentUser());
        view()->share('repository', $repository);
    }

    /**
     * @return string
     */
    abstract public function getViewName();

    /**
     * @return User
     */
    public function getCurrentUser()
    {
        return $this->auth->check();
    }

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
     * @param string $action
     *
     * @return string
     */
    public function getAccess($action)
    {
        return $this->getModule().'.'.$this->getViewName().'.'.$action;
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
     * @return array of table column
     */
    abstract protected function configureDatagridColumns();

    /**
     * @return QueryBuilder
     */
    protected function createQuery()
    {
        $model = new $this->modelClass;
        $columns = $this->configureDatagridColumns();

        $query = $model->select($columns);
        $this->configureQuery($query);

        return $query;
    }

    /**
     * @param QueryBuilder $query
     */
    protected function configureQuery(QueryBuilder $query)
    {
    }

    /**
     * @return array
     */
    protected function configureDatagridParameters()
    {
        return [
            'order' => [[ 0, 'desc' ]]
        ];
    }

    /**
     * @param TableBuilder $builder
     *
     * @return TableBuilder
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {
        return $builder->columns($this->configureDatagridColumns());
    }

    /**
     * @param EloquentEngine $dataTable
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
    }

    /**
     * @param EloquentEngine $dataTable
     * @param Request        $request
     */
    protected function configureDatagridFilters(EloquentEngine $dataTable, Request $request)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request    $request
     * @param Datatables $dataTable
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request, Datatables $dataTable)
    {
        if ($request->ajax()) {
            $query = $this->createQuery();

            $dataTable = $dataTable->usingEloquent($query);
            $this->configureDatagridValues($dataTable);
            $this->configureDatagridFilters($dataTable, $request);

            if ($this->getCurrentUser()->hasAccess($this->getAccess('show')) || $this->getCurrentUser()->hasAccess($this->getAccess('edit')) || $this->getCurrentUser()->hasAccess($this->getAccess('destroy'))) {
                $dataTable->addColumn('action', function (Model $model) {
                    $actions = '';
                    if ($this->getCurrentUser()->hasAccess($this->getAccess('show'))) {
                        $actions .= '<a href="'.$this->route('show', ['id' => $model->id]).'" class="btn btn-default btn-flat"><i class="glyphicon glyphicon-eye-open"></i></a>';
                    }
                    if ($this->getCurrentUser()->hasAccess($this->getAccess('edit'))) {
                        $actions .= '<a href="'.$this->route('edit', ['id' => $model->id]).'" class="btn btn-default btn-flat"><i class="glyphicon glyphicon-pencil"></i></a>';
                    }
                    if ($this->getCurrentUser()->hasAccess($this->getAccess('destroy'))) {
                        $actions .= \Form::open([
                            'route' => [$this->getRoute('destroy'), $model->id],
                            'method' => 'delete',
                            'style' => 'display:inline',
                        ]);
                        $actions .= '<button type="button" class="btn btn-danger btn-flat model-destroy" data-toggle="modal" data-target="#confirm-destroy"><i class="glyphicon glyphicon-trash"></i></button>';
                        $actions .= \Form::close();
                    }

                    return $actions;
                });
            }

            return $dataTable->make(true);
        }
        else {
            $datagridParameters = array_merge([
                'stateSave' => true,
                'language' => [
                    'url' => \Module::asset('Core:js/vendor/datatables/ru.json')
                ]
            ], $this->configureDatagridParameters());

            $this->builder->parameters($datagridParameters);
            $this->configureDatagridFields($this->builder);

            if ($this->getCurrentUser()->hasAccess($this->getAccess('show')) || $this->getCurrentUser()->hasAccess($this->getAccess('edit')) || $this->getCurrentUser()->hasAccess($this->getAccess('destroy'))) {
                $this->builder
                    ->addAction(['data' => 'action', 'title' => $this->trans('table.actions'), 'orderable' => false, 'searchable' => false])
                ;
            }

            $html = $this->builder;

            return view($this->getView('index'), $this->mergeViewData(compact('html')));
        }
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
     * Display the one of the resource.
     *
     * @param Model $model
     *
     * @return \Illuminate\View\View
     */
    public function show(Model $model)
    {
        return view($this->getView('show'), $this->mergeViewData(compact('model')));
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
        $currentUser = $this->getCurrentUser();

        if (method_exists($model, 'village') && !$this->getCurrentUser()->inRole('admin')) {
            $model->village()->associate($currentUser->village);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Model $model
     * @return \Illuminate\View\View
     */
    public function edit(Model $model)
    {
        $redirect = $this->checkPermission($model);
        if ($redirect !== true) {
            return $redirect;
        }

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
        $redirect = $this->checkPermission($model);
        if ($redirect !== true) {
            return $redirect;
        }

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
        $redirect = $this->checkPermission($model);
        if ($redirect !== true) {
            return $redirect;
        }

        $this->getRepository()->destroy($model);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => $this->trans('title.model')]));

        return redirect()->route($this->getRoute('index'));
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Validation\Validator
     */
    public function validate(array $data)
    {
        throw new \RuntimeException('method must be implemented');
    }

    protected function checkPermission(Model $model)
    {
        if (method_exists($model, 'village') && !$this->getCurrentUser()->inRole('admin')) {
            if ((int)$model->village->id !== (int)$this->getCurrentUser()->village->id) {
                return redirect()->route($this->getRoute('index'));
            }
        }

        return true;
    }
}
