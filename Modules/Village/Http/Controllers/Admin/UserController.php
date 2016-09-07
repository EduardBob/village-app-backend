<?php namespace Modules\Village\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\User\Repositories\RoleRepository;
use Modules\User\Repositories\UserRepository;
use Modules\Village\Entities\User;
use Response;
use Validator;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Html\Builder as TableBuilder;

class UserController extends AdminController
{

    /**
     * @var UserRepository
     */
    private $user;
    /**
     * @var RoleRepository
     */
    private $role;

    /**
     * @param UserRepository $user
     * @param RoleRepository $role
     */
    public function __construct(UserRepository $user, RoleRepository $role)
    {
        parent::__construct($user, User::class);

        $this->user = $user;
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getModule()
    {
        return 'user';
    }

    public function getClass()
    {
        return 'user';
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridColumns()
    {
        return ['users.*'];
    }

    /**
     * @inheritdoc
     */
    protected function configureQuery(QueryBuilder $query)
    {
        $query
          ->leftJoin('village__villages', 'users.village_id', '=', 'village__villages.id')
          ->where('village__villages.deleted_at', null)
          ->leftJoin('village__buildings', 'users.building_id', '=', 'village__buildings.id')
          ->leftJoin('activations', 'users.id', '=', 'activations.user_id')
          ->groupBy('users.id')
          ->with(['village', 'building', 'activation']);

        if (!$this->getCurrentUser()->inRole('admin')) {
            $query->where('users.village_id', $this->getCurrentUser()->village->id);
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFields(TableBuilder $builder)
    {
        $builder
          ->addColumn(['data' => 'id', 'name' => 'users.id', 'title' => 'ID']);

        if ($this->getCurrentUser()->inRole('admin')) {
            $builder
              ->addColumn(['data' => 'village_name', 'name' => 'village__villages.name', 'title' => trans('village::villages.title.model')]);
        }

        $builder
          ->addColumn(['data' => 'roles', 'title' => trans('user::users.tabs.roles'), 'searchable' => false, 'orderable' => false])
          ->addColumn(['data' => 'first_name', 'name' => 'users.first_name', 'title' => $this->trans('form.first-name')])
          ->addColumn(['data' => 'last_name', 'name' => 'users.last_name', 'title' => $this->trans('form.last-name')])
          ->addColumn(['data' => 'phone', 'name' => 'users.phone', 'title' => trans('village::users.form.phone')])
          ->addColumn(['data' => 'email', 'name' => 'users.email', 'title' => $this->trans('form.email')])
          ->addColumn(['data' => 'building_address', 'name' => 'village__buildings.address', 'title' => trans('village::users.form.building_id')])
          ->addColumn(['data' => 'has_mail_notifications', 'name' => 'users.has_mail_notifications', 'title' => trans('village::users.form.has_mail_notifications')])
          ->addColumn(['data' => 'has_sms_notifications', 'name' => 'users.has_mail_notifications', 'title' => trans('village::users.form.has_sms_notifications')])
          ->addColumn(['data' => 'activation_completed', 'name' => 'activations.completed', 'title' => $this->trans('form.status')]);
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridValues(EloquentEngine $dataTable)
    {
        if ($this->getCurrentUser()->inRole('admin')) {
            $dataTable
              ->editColumn('village_name', function (User $user) {
                  if (!$user->village) {
                      return '';
                  }
                  if ($this->getCurrentUser()->hasAccess('village.villages.edit')) {
                      return '<a href="' . route('admin.village.village.edit', ['id' => $user->village->id]) . '">' . $user->village->name . '</a>';
                  } else {
                      return $user->village->name;
                  }
              });
        }

        $dataTable
          ->editColumn('building_address', function (User $user) {
              if (!$user->building) {
                  return '';
              }
              if ($this->getCurrentUser()->hasAccess('village.buildings.edit')) {
                  return '<a href="' . route('admin.village.building.edit', ['id' => $user->building->id]) . '">' . $user->building->address . '</a>';
              } else {
                  return $user->building->address;
              }
          })
          ->editColumn('has_mail_notifications', function (User $user) {
              if ($user->has_mail_notifications) {
                  return '<span class="label label-success">' . trans('village::admin.table.active.yes') . '</span>';
              }
              return '<span class="label label-danger">' . trans('village::admin.table.active.no') . '</span>';
          })
          ->editColumn('has_sms_notifications', function (User $user) {
              if ($user->has_sms_notifications) {
                  return '<span class="label label-success">' . trans('village::admin.table.active.yes') . '</span>';
              }
              return '<span class="label label-danger">' . trans('village::admin.table.active.no') . '</span>';
          })
          ->editColumn('activation_completed', function (User $user) {
              if ($user->isActivated()) {
                  return '<span class="label label-success">' . trans('village::admin.table.active.yes') . '</span>';
              } else {
                  return '<span class="label label-danger">' . trans('village::admin.table.active.no') . '</span>';
              }
          })
          ->addColumn('roles', function (User $user) {
              $inRoles = [];
              foreach ($user->getRoles()->getIterator() as $role) {
                  $inRoles[] = $role->name;
              }
              return implode(', ', $inRoles);
          });
    }

    /**
     * @inheritdoc
     */
    public function create()
    {
        $view = parent::create();

        $roles = $this->getPermittedRoles();
        view()->share('roles', $roles);

        return $view;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = $this->validate($request->all());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $this->clearNotPermittedRoles($request->all());

        $this->user->createWithRoles($data, @$data['roles'], $data['activated']);

        flash(trans('user::messages.user created'));

        return redirect()->route('admin.user.user.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $view = parent::edit($id);

        $roles = $this->getPermittedRoles();
        view()->share('roles', $roles);

        return $view;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param  Request $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $model = $this->getRepository()->find($id);

        $validator = $this->validate($request->all(), $model);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $this->clearNotPermittedRoles($request->all());

        $this->user->updateAndSyncRoles($id, $data, @$data['roles']);

        flash(trans('user::messages.user updated'));

        return redirect()->route('admin.user.user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int|Model $model
     *
     * @return Response
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

        $this->getRepository()->delete($model->id);

        flash(trans('user::messages.user deleted'));

        return redirect()->route($this->getRoute('index'));
    }

    /**
     * @param array $data
     * @param User $user
     *
     * @return Validator
     */
    public function validate(array $data, User $user = null)
    {
        $id = $user ? $user->id : null;

        $rules = [
//            'address' => "required|max:255|unique:village__buildings,address,{$id}",
          'first_name' => 'required',
          'last_name'  => 'required',
          'email'      => "email|unique:users,email,{$id}",
//            'password' => 'min:3|confirmed',
          'phone'      => 'required|regex:' . config('village.user.phone.regex'),
        ];

        if (!$this->getCurrentUser()->inRole('admin')) {
            $rules['village_id'] = 'required|exists:village__villages,id';
        }

        return Validator::make($data, $rules);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getPermittedRoles()
    {
        $roles = $this->role->all();

        if (!$this->getCurrentUser()->inRole('admin')) {
            $adminRoles = ['user', 'village-admin', 'executor', 'security', 'creatorservices', 'viewsurveys', 'creatorsurvey', 'creatornews', 'nouser'];
            foreach ($roles as $key => $role) {
                if (!in_array($role->slug, $adminRoles)) {
                    unset($roles[$key]);
                }
            }
        }

        return $roles;
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    private function clearNotPermittedRoles(array $data)
    {
        $roles = @$data['roles'];

        if (is_array($roles)) {
            $permittedRoles = $this->getPermittedRoles();
            foreach ($roles as $index => $roleId) {
                if (!$permittedRoles->contains('id', $roleId)) {
                    unset($roles[$index]);
                }
            }

            $data['roles'] = $roles;
        } else {
            $data['roles'] = ['']; // need for delete role relations
        }

        return $data;
    }
}
