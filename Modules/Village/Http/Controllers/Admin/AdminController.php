<?php namespace Modules\Village\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Core\Contracts\Authentication;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Core\Repositories\BaseRepository;

use Modules\Village\Entities\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\Datatables\Datatables;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Html\Builder as TableBuilder;

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
    public function __construct($repository, $modelClass = null)
    {
        parent::__construct();

        $this->repository = $repository;
        $this->modelClass = $modelClass;

        $this->builder = app('Yajra\Datatables\Html\Builder');
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

        return view()->exists($modelView) ? $modelView : 'village::admin.admin.'.$action;
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
            'order' => [[ 0, 'desc' ]],
            "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "Все"]],
            'iDisplayLength' => 50, // http://legacy.datatables.net/usage/options#iDisplayLength
            // // http://datatables.net/reference/option/dom
            // defaukt Blfrtip
            'dom' => 'lBfrtip', //Bfrtip // lfrtBip // Blfrtip
            'buttons' => [
                [
                    'extend' => 'collection',
                    'text' => 'Экспорт',
                    'select' => true,
                    'buttons' => ['copy','csv', 'excel', 'pdf', 'print']
                ]
            ],
        ];
    }

    /**
     * @param TableBuilder $builder
     *
     * @return TableBuilder
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {
        return $builder
            ->columns($this->configureDatagridColumns())
            ->parameters([
                'dom' => 'Bfrtip',
                'text' => 'Export',
                'select' => true,
                'buttons' => [
                    'buttons' => ['csv', 'excel', 'pdf', 'print', 'reset', 'reload']
                ],
            ])
        ;
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
        $redirect = $this->checkPermissionDenied($model);
        if ($redirect !== false) {
            return $redirect;
        }

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
        $data = $request->all();
        $model = new $this->modelClass();

        if (!$this->getCurrentUser()->inRole('admin') && method_exists($model, 'village')) {
            $data['village_id'] = $this->getCurrentUser()->village_id;
        }

        $validator = $this->validate($data);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $model->fill($data);
        $this->preStore($model, $request);
        $model->save();
	    $this->postStore($model, $request);

        flash()->success(trans('core::core.messages.resource created', ['name' => $this->trans('title.model')]));

	    return redirect()->route($this->getRoute('edit'), ['id'  => $model->id]);
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
	 * @param Model   $model
	 * @param Request $request
	 */
	public function postStore(Model $model, Request $request)
	{
		$this->copyBaseImage($model, $request);
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param Model|int $model
     * @return \Illuminate\View\View
     */
    public function edit($model)
    {
        if (!$model instanceof Model) {
            $model = $this->getRepository()->find($model);
        }
        if (isset($model->deleted_at) && !is_null($model->deleted_at)) {
            flash()->error(trans('Запись не найдена'));

            return redirect()->route($this->getRoute('index'));
        }

        $redirect = $this->checkPermissionDenied($model);
        if ($redirect !== false) {
            return $redirect;
        }

        return view($this->getView('edit'), $this->mergeViewData(compact('model')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Model|int $model
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($model, Request $request)
    {
        if (!$model instanceof Model) {
            $model = $this->getRepository()->find($model);
        }

        if (isset($model->deleted_at) && !is_null($model->deleted_at)) {
            flash()->error(trans('Запись не найдена'));

            return redirect()->route($this->getRoute('index'));
        }

        $redirect = $this->checkPermissionDenied($model);
        if ($redirect !== false) {
            return $redirect;
        }

        $data = $request->all();
        $validator = $this->validate($data, $model);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

	    if (isset($data['imageable'])) {
		    $mediaId = $data['imageable']['mediaId'];
		    $entityClass = $data['imageable']['entityClass'];
		    $entityId = $data['imageable']['entityId'];

		    $entity = $entityClass::find($entityId);
		    $zone = $request->get('zone');
		    $entity->files()->attach($mediaId, ['imageable_type' => $entityClass, 'zone' => $zone]);
		    $imageable = DB::table('media__imageables')->whereFileId($mediaId)->whereZone($zone)->whereImageableType($entityClass)->first();
		    $file = $this->file->find($imageable->file_id);

		    $thumbnailPath = $this->imagy->getThumbnail($file->path, 'mediumThumb');

		    event(new FileWasLinked($file, $entity));
	    }

        $model->fill($data);
        $this->preUpdate($model, $request);
        $model->save();

        flash()->success(trans('core::core.messages.resource updated', ['name' => $this->trans('title.model')]));

        return redirect()->route($this->getRoute('edit'), ['id'  => $model->id]);
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
     * @param  Model|int $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($model)
    {
        if (!$model instanceof Model) {
            $model = $this->getRepository()->find($model);
        }

        $redirect = $this->checkPermissionDenied($model);
        if ($redirect !== false) {
            return $redirect;
        }

        $this->preDestroy($model);
        $this->getRepository()->destroy($model);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => $this->trans('title.model')]));

        return redirect()->route($this->getRoute('index'));
    }

    /**
     * @param Model   $model
     */
    public function preDestroy(Model $model)
    {
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

    /**
     * @param Model $model
     *
     * @return false|\Illuminate\Http\RedirectResponse
     */
    protected function checkPermissionDenied(Model $model)
    {
        if (method_exists($model, 'village') && !$this->getCurrentUser()->inRole('admin')) {
            if (!$model->village || (int)$model->village->id !== (int)$this->getCurrentUser()->village->id) {
                return redirect()->route($this->getRoute('index'));
            }
        }

        return false;
    }

	/**
	 * @param Model   $model
	 * @param Request $request
	 * @param string  $zone
	 */
	protected function copyBaseImage(Model $model, Request $request, $zone = 'media')
	{
		if (isset($model->base_id) && $model->base->files) {
			$mediaId = $model->base->files->first();
			$model->files()->attach($mediaId, ['imageable_type' => get_class($model), 'zone' => $zone]);
		}
	}

}
