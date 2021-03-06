<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1-1" data-toggle="tab">{{ trans('user::users.tabs.data') }}</a></li>
        @if($currentUser->hasAccess('user.users.update'))
        <li class=""><a href="#tab_2-2" data-toggle="tab">{{ trans('user::users.tabs.roles') }}</a></li>
        {{--<li class=""><a href="#tab_3-3" data-toggle="tab">{{ trans('user::users.tabs.permissions') }}</a></li>--}}
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
                            {!! Form::text('first_name', Input::old('first_name', @$model->first_name), ['class' => 'form-control', 'placeholder' => trans('user::users.form.first-name')]) !!}
                            {!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            {!! Form::label('last_name', trans('user::users.form.last-name')) !!}
                            {!! Form::text('last_name', Input::old('last_name', @$model->last_name), ['class' => 'form-control', 'placeholder' => trans('user::users.form.last-name')]) !!}
                            {!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group{{ $errors->has('phone') ? ' has-error has-feedback' : '' }}">
                            {!! Form::label('phone', trans('village::users.form.phone')) !!}
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                {!! Form::text('phone', Input::old('phone', @$model->phone), [
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
                            {!! Form::email('email', Input::old('email', @$model->email), ['class' => 'form-control', 'placeholder' => trans('user::users.form.email')]) !!}
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
                                    Input::old('village_id', @$model->village_id),
                                    ['class' => 'form-control', 'placeholder' => trans('village::villages.form.village.placeholder')]
                                )
                            !!}
                            {!! $errors->first('village_id', '<span class="help-block">:message</span>') !!}
                        </div>
                        @if( isset($model) && @$model->inRole('executor'))
                            <?php $selectedVillages = [] ?>
                            @if(@$model->additionalVillages)
                                <?php $selectedVillages = $model->additionalVillages()->select('village_id')->lists('village_id')->toArray() ?>
                            @endif
                            <div class="form-group{{ $errors->has('additional_villages') ? ' has-error has-feedback' : '' }}">
                                {!! Form::label('additional_villages',  trans('village::users.form.additional_villages')) !!}
                                <select class="form-control" multiple="additional_villages" name="additional_villages[]" id="additional_villages">
                                    @foreach((new Modules\Village\Entities\Village)->lists('name', 'id') as $id => $title)
                                            @if(@$model->village->id != $id)
                                            <option value="{{$id}}" @if(in_array($id, $selectedVillages)) selected="selected"  @endif >{{$title}}</option>
                                            @endif
                                    @endforeach
                                </select>
                                <a href="#null" onclick="$('#additional_villages').val(null);">{{ trans('village::users.form.cancel_selection') }}</a>
                                <p>
                                    <i>{{ trans('village::users.form.additional_villages_info') }}</i>
                                </p>
                                {!! $errors->first('village_id', '<span class="help-block">:message</span>') !!}
                            </div>
                        @endif
                    </div>
                    @else
                        {!! Form::hidden('village_id', isset($model) ? $model->village_id : $currentUser->village_id, ['id' => 'village_id']) !!}
                    @endif
                    @if($currentUser->hasAccess('village.buildings.getChoicesByVillage'))
                    <div class="col-sm-6">
                        <div class="form-group{{ $errors->has('building_id') ? ' has-error has-feedback' : '' }}">
                            {!! Form::label('building_id', trans('village::users.form.building_id')) !!}
                            {!! Form::select(
                                    'building_id', [],//Input::old('id', (new Modules\Village\Entities\Building)->lists('address', 'id'))
                                    Input::old('building_id', @$model->building_id),
                                    ['class' => 'form-control', 'placeholder' => trans('village::users.form.building.placeholder')]
                                )
                            !!}
                            {!! $errors->first('building_id', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    @else
                        {!! Form::hidden('building_id', @$model->building_id, ['id' => 'building_id']) !!}
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="checkbox{{ $errors->has('activated') ? ' has-error' : '' }}">
                            <input type="hidden" value="{{ @$model->id === $currentUser->id ? '1' : '0' }}" name="activated"/>
                            <?php $oldValue = !isset($model) || (bool)$model->isActivated() ? 'checked' : ''; ?>
                            <label for="activated">
                                <input id="activated"
                                       name="activated"
                                       type="checkbox"
                                       class="flat-blue"
                                       {{ @$model->id === $currentUser->id ? 'disabled' : '' }}
                                       {{ Input::old('activated', $oldValue) }}
                                       value="1" />
                                {{ trans('user::users.form.status') }}
                                {!! $errors->first('activated', '<span class="help-block">:message</span>') !!}
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="checkbox{{ $errors->has('has_mail_notifications') ? ' has-error' : '' }}">
                            {!! Form::checkbox('has_mail_notifications', (int)Input::old('has_mail_notifications', @$model->has_mail_notifications), (bool)Input::old('has_mail_notifications', @$model->has_mail_notifications), ['class' => 'flat-blue']) !!}
                            {!! Form::label('has_mail_notifications', trans('village::users.table.has_mail_notifications')) !!}
                            {!! $errors->first('has_mail_notifications', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="checkbox{{ $errors->has('has_sms_notifications') ? ' has-error' : '' }}">
                            {!! Form::checkbox('has_sms_notifications', (int)Input::old('has_sms_notifications', @$model->has_sms_notifications), (bool)Input::old('has_sms_notifications', @$model->has_sms_notifications), ['class' => 'flat-blue']) !!}
                            {!! Form::label('has_sms_notifications', trans('village::users.table.has_sms_notifications')) !!}
                            {!! $errors->first('has_sms_notifications', '<span class="help-block">:message</span>') !!}
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
                                <option value="{{ $role->id }}" <?php echo isset($model) && $model->hasRoleId($role->id) ? 'selected' : '' ?>>{{ $role->name }}</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        {{--<div class="tab-pane" id="tab_3-3">--}}
            {{--<div class="box-body">--}}
                {{--@include('user::admin.partials.permissions', ['model' => @$model])--}}
            {{--</div>--}}
        {{--</div>--}}
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
                    {{--<div class="col-md-6">--}}
                        {{--<h4>{{ trans('user::users.tabs.or send reset password mail') }}</h4>--}}
                        {{--<a href="#" class="btn btn-flat bg-maroon" data-toggle="tooltip" data-placement="bottom" title="Coming soon">--}}
                            {{--{{ trans('user::users.send reset password email') }}--}}
                        {{--</a>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>