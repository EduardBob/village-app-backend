@section('buttons')
  @parent

{!! Form::open(['route' => [$admin->getRoute('edit'), $model->id], 'method' => 'get']) !!}
<button name="pushDocument" value="1" type="submit" class="btn btn-danger btn-flat pull-right">{{ $admin->trans('button.updateAndPush') }}</button>
{!! Form::close() !!}
<span class="pull-right">&nbsp;&nbsp;&nbsp;</span>
@stop

<div class="box-body">
    @if($currentUser->hasAccess('village.documents.makePersonal'))
        @inject('roles', 'Cartalyst\Sentinel\Roles\EloquentRole')
    @endif

    <?php $villages = (new Modules\Village\Entities\Village())->where('active', 1)->lists('name', 'id'); ?>

    <div class="row">
        @if($currentUser && $currentUser->inRole('admin'))
            <div class="col-sm-4">
                <div class="form-group{{ $errors->has('village_id') ? ' has-error has-feedback' : '' }}">
                    {!! Form::label('village_id', trans('village::villages.form.village_id')) !!}
                    {!! Form::select(
                            'village_id', Input::old('id', $villages),
                            Input::old('village_id', @$model->village_id),
                            ['class' => 'form-control', 'placeholder' => $admin->trans('table.village_id')]
                        )
                    !!}
                    {!! $errors->first('village_id', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        @else
            <input type="hidden" id="village_id" value="{!! $currentUser->village->id !!}" />
        @endif

        @if($currentUser->hasAccess('village.documents.makePersonal'))
            <div class="col-sm-2">
                <div class="personal-switch form-group{{ $errors->has('is_personal') ? ' has-error' : '' }}">
                    {!! Form::checkbox('is_personal', (int)Input::old('is_personal', @$model->is_personal), (bool)Input::old('is_personal', @$model->is_personal), ['class' => 'flat-blue']) !!}
                    {!! Form::label('is_personal', $admin->trans('table.is_personal')) !!}
                    {!! $errors->first('is_personal', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
          @else
            <input type="hidden" value="0" name="is_personal" />
        @endif
            <div class="col-sm-6">
                <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                    {!! Form::label('category_id', $admin->trans('table.category_id')) !!}
                    {!! Form::select('category_id', $admin->getCategories(),
                    @$model->category->id?:Input::old('category_id'), ['class' => 'form-control'], '') !!}
                    {!! $errors->first('category_id', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        @if($currentUser->hasAccess('village.documents.makePersonal'))
            <div class="col-sm-12 users-holder">
                <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
                    {!! Form::label('role_id',  $admin->trans('table.role_id')) !!}
                    <select name="role_id" id="role_id" class="form-control">
                        <option value="">{{  $admin->trans('form.all_roles')  }}</option>
                        @foreach ($roles->all() as $id => $role)
                          <option  @if($role->id  == @$model->role_id ) selected="selected" @endif value="{!! $role->id !!}">{!! $role->name !!}</option>
                        @endforeach
                    </select>
                    {!! $errors->first('role_id', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="users-holder form-group{{ $errors->has('buildings') ? ' has-error' : '' }}">
                    {!! Form::label('buildings', $admin->trans('form.buildings')) !!}<br/>
                    <select data-placeholder="{{$admin->trans('form.to_all_buildings')}}" class="form-control" name="buildings[]" id="buildings" multiple="multiple"></select>
                    {!! $errors->first('buildings', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="users-holder form-group{{ $errors->has('users') ? ' has-error' : '' }}">
                    {!! Form::label('users', $admin->trans('form.users')) !!}<br/>
                    <select data-placeholder="Всем пользователям" class="form-control" name="users[]" id="users_select" multiple="multiple"></select>
                    {!! $errors->first('users', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        @endif
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('published_at') ? ' has-error' : '' }}">
                {!! Form::label('published_at', $admin->trans('table.published_at')) !!}
                {!! Form::text('published_at', localizeddate(@$model->published_at, 'medium_short') ? : localizeddate('now', 'medium_short')
                 , ['class' => 'form-control js-date-time-field', 'placeholder' => localizeddate('now', 'medium_short')]) !!}
                {!! $errors->first('published_at', '<span class="help-block">:message</span>') !!}

            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                {!! Form::label('title', $admin->trans('table.title')) !!}
                {!! Form::text('title', Input::old('title', @$model->title), ['class' => 'form-control', 'placeholder' => $admin->trans('table.title')]) !!}
                {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                {!! Form::label('text', $admin->trans('table.text').'*') !!}
                {!! Form::textarea('text', Input::old('text', @$model->text), ['class' => 'form-control  ckeditor', 'placeholder' => $admin->trans('table.text')]) !!}
                <p><i>*{{$admin->trans('form.text_info')}}</i></p>
                {!! $errors->first('text', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                {!! Form::checkbox('active', (int)Input::old('active', @$model->active), (bool)Input::old('active', @$model->active), ['class' => 'flat-blue']) !!}
                {!! Form::label('active', $admin->trans('table.active')) !!}
                {!! $errors->first('active', '<span class="help-block">:message</span>') !!}
            </div>
        </div>

        @if($currentUser && $currentUser->inRole('admin'))
                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('is_protected') ? ' has-error' : '' }}">
                        {!! Form::checkbox('is_protected', (int)Input::old('is_protected', @$model->is_protected), (bool)Input::old('is_protected', @$model->is_protected), ['class' => 'flat-blue']) !!}
                        {!! Form::label('is_protected', $admin->trans('table.is_protected')) !!}
                        {!! $errors->first('is_protected', '<span class="help-block">:message</span>') !!}

                    </div>
                </div>
        @endif
        @if(isset($model))
        <div class="col-sm-12">
            @include('media::admin.fields.file-link', [
                'entityClass' => 'Modules\\\\Village\\\\Entities\\\\Document',
                'entityId' => @$model->id,
                'zone' => 'media',
                'media' => $model->files()->first()
            ])
        </div>
        @endif
    </div>
</div>