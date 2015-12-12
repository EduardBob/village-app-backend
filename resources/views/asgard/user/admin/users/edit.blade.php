@extends('layouts.master')

@section('content-header')
<h1>
    {{ trans('user::users.title.edit-user') }} <small>{{ $user->present()->fullname() }}</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ URL::route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li class=""><a href="{{ URL::route('admin.user.user.index') }}">{{ trans('user::users.breadcrumb.users') }}</a></li>
    <li class="active">{{ trans('user::users.breadcrumb.edit-user') }}</li>
</ol>
@stop

@section('styles')
    {!! Theme::style('css/vendor/iCheck/flat/blue.css') !!}
    {!! Theme::script('vendor/jquery/dist/jquery.min.js') !!}
@stop

@section('content')
{!! Form::open(['route' => ['admin.user.user.update', $user->id], 'method' => 'put']) !!}
<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1-1" data-toggle="tab">{{ trans('user::users.tabs.data') }}</a></li>
                @if($currentUser->hasAccess('user.users.update'))
                <li class=""><a href="#tab_2-2" data-toggle="tab">{{ trans('user::users.tabs.roles') }}</a></li>
                <li class=""><a href="#tab_3-3" data-toggle="tab">{{ trans('user::users.tabs.permissions') }}</a></li>
                <li class=""><a href="#password_tab" data-toggle="tab">{{ trans('user::users.tabs.new password') }}</a></li>
                @endif
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1-1">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                    {!! Form::label('first_name', trans('user::users.form.first-name')) !!}
                                    {!! Form::text('first_name', Input::old('first_name', $user->first_name), ['class' => 'form-control', 'placeholder' => trans('user::users.form.first-name')]) !!}
                                    {!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                    {!! Form::label('last_name', trans('user::users.form.last-name')) !!}
                                    {!! Form::text('last_name', Input::old('last_name', $user->last_name), ['class' => 'form-control', 'placeholder' => trans('user::users.form.last-name')]) !!}
                                    {!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('phone') ? ' has-error has-feedback' : '' }}">
                                    {!! Form::label('phone', trans('village::users.form.phone')) !!}
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                        {!! Form::text('phone', Input::old('phone', @$user->phone), [
                                            'class' => 'form-control',
                                            'placeholder' => trans('village::users.form.phone'),
                                            'data-inputmask' => '"mask": "'.config('village.user.phone.mask').'"',
                                            'data-mask' => ''
                                        ]) !!}
                                    </div>
                                    {!! $errors->first('phone', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    {!! Form::label('email', trans('user::users.form.email')) !!}
                                    {!! Form::email('email', Input::old('email', @$user->email), ['class' => 'form-control', 'placeholder' => trans('user::users.form.email')]) !!}
                                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @if($currentUser && $currentUser->inRole('admin'))
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('village_id') ? ' has-error has-feedback' : '' }}">
                                    {!! Form::label('village_id', trans('village::villages.form.village_id')) !!}
                                    {!! Form::select(
                                            'village_id', Input::old('id', (new Modules\Village\Entities\Village)->lists('name', 'id')),
                                            Input::old('village_id', @$user->village_id),
                                            ['class' => 'form-control', 'placeholder' => trans('village::villages.form.village.placeholder')]
                                        )
                                    !!}
                                    {!! $errors->first('village_id', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            @else
                                {!! Form::hidden('village_id', $user->village_id, ['id' => 'village_id']) !!}
                            @endif
                            @if($currentUser->hasAccess('village.buildings.getChoicesByVillage'))
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('building_id') ? ' has-error has-feedback' : '' }}">
                                    {!! Form::label('building_id', trans('village::users.form.building_id')) !!}
                                    {!! Form::select(
                                            'building_id', [],//Input::old('id', (new Modules\Village\Entities\Building)->lists('address', 'id'))
                                            Input::old('building_id', @$user->building_id),
                                            ['class' => 'form-control', 'placeholder' => trans('village::users.form.building.placeholder')]
                                        )
                                    !!}
                                    {!! $errors->first('building_id', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            @else
                                {!! Form::hidden('building_id', $user->building_id, ['id' => 'building_id']) !!}
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="checkbox{{ $errors->has('activated') ? ' has-error' : '' }}">
                                    <input type="hidden" value="{{ $user->id === $currentUser->id ? '1' : '0' }}" name="activated"/>
                                    <?php $oldValue = (bool) $user->isActivated() ? 'checked' : ''; ?>
                                    <label for="activated">
                                        <input id="activated"
                                               name="activated"
                                               type="checkbox"
                                               class="flat-blue"
                                               {{ $user->id === $currentUser->id ? 'disabled' : '' }}
                                               {{ Input::old('activated', $oldValue) }}
                                               value="1" />
                                        {{ trans('user::users.form.status') }}
                                        {!! $errors->first('activated', '<span class="help-block">:message</span>') !!}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($currentUser->hasAccess('user.users.update'))
                <div class="tab-pane" id="tab_2-2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('user::users.tabs.roles') }}</label>
                                <select multiple="" class="form-control" name="roles[]">
                                    <?php foreach ($roles as $role): ?>
                                        <option value="{{ $role->id }}" <?php echo $user->hasRoleId($role->id) ? 'selected' : '' ?>>{{ $role->name }}</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_3-3">
                    <div class="box-body">
                        @include('user::admin.partials.permissions', ['model' => $user])
                    </div>
                </div>
                <div class="tab-pane" id="password_tab">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>{{ trans('user::users.new password setup') }}</h4>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    {!! Form::label('password', trans('user::users.form.new password')) !!}
                                    {!! Form::input('password', 'password', '', ['class' => 'form-control']) !!}
                                    {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                                </div>
                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    {!! Form::label('password_confirmation', trans('user::users.form.new password confirmation')) !!}
                                    {!! Form::input('password', 'password_confirmation', '', ['class' => 'form-control']) !!}
                                    {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4>{{ trans('user::users.tabs.or send reset password mail') }}</h4>
                                <a href="#" class="btn btn-flat bg-maroon" data-toggle="tooltip" data-placement="bottom" title="Coming soon">
                                    {{ trans('user::users.send reset password email') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="box-footer">
                    @if($currentUser->hasAccess('user.users.update'))
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('user::button.update') }}</button>
                        <button class="btn btn-default btn-flat" name="button" type="reset">{{ trans('core::core.button.reset') }}</button>
                    @endif
                    @if($currentUser->hasAccess('user.users.index'))
                        <a class="btn btn-danger pull-right btn-flat" href="{{ URL::route('admin.user.user.index')}}"><i class="fa fa-times"></i> {{ trans('user::button.cancel') }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@stop
@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('user::users.navigation.back to index') }}</dd>
    </dl>
@stop
@section('scripts')
    @parent

<script>
$( document ).ready(function() {
    $("[data-mask]").inputmask();

    $('[data-toggle="tooltip"]').tooltip();
    $(document).keypressAction({
        actions: [
            { key: 'b', route: "<?= route('admin.user.role.index') ?>" }
        ]
    });
    $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });

    @if($currentUser->hasAccess('village.buildings.getChoicesByVillage'))
    var $village = $('#village_id');
    $village.change(function(){
        var $building = $("#building_id");
        $building.html('');
        var selectedVillageId = $village.val();
        if (selectedVillageId > 0) {
            $.get('{{ URL::route('admin.village.building.get_choices_by_village', [null, null]) }}/'+selectedVillageId+'/'+'{{ $user->building_id }}', function(data){
                $building.html(data);
            });
        }
    });

    $village.trigger('change');
    @endif
});
</script>
@stop
