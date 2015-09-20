<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('service') ? ' has-error' : '' }}">
                {!! Form::label('service', $admin->trans('table.service')) !!}
                {!! Form::select('service', (new Modules\Village\Entities\Service)->lists('title', 'id'),
                Input::old('service', @$model->service->id), ['class' => 'form-control', 'placeholder' => $admin->trans('form.service.placeholder')]) !!}
                {!! $errors->first('service', '<span class="help-block">:message</span>') !!}
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('profile') ? ' has-error' : '' }}">
                {!! Form::label('profile', $admin->trans('table.profile')) !!}
                {!! Form::select('profile', (new Modules\Village\Entities\Profile)->getList(),
                Input::old('profile', @$model->profile->user->id), ['class' => 'form-control', 'placeholder' => $admin->trans('form.profile.placeholder')]) !!}
                {!! $errors->first('profile', '<span class="help-block">:message</span>') !!}
            </div>
        </div>

        <div class="col-sm-4">
        	<div class="form-group{{ $errors->has('perform_at') ? ' has-error' : '' }}">
        	    {!! Form::label('perform_at', $admin->trans('table.perform_at')) !!}
        	    {!! Form::text('perform_at', Input::old('perform_at', Carbon\Carbon::parse(@$model->perform_at)->format(config('village.date.format'))), ['class' => 'js-date-field form-control']) !!}
        	    {!! $errors->first('perform_at', '<span class="help-block">:message</span>') !!}
        	</div>
        </div>

        <?php if (isset($model)): ?>
        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                {!! Form::label('status', $admin->trans('table.status')) !!}
                {!! Form::select('status', array_combine(config('village.order.statuses'), $admin->trans('form.status.values')),
                Input::old('status', @$model->status), ['class' => 'form-control', 'placeholder' => $admin->trans('form.status.placeholder')]) !!}
                {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('decline_reason') ? ' has-error' : '' }}">
                {!! Form::label('decline_reason', $admin->trans('table.decline_reason')) !!}
                {!! Form::textarea('decline_reason', Input::old('decline_reason', @$model->decline_reason), ['class' => 'form-control']) !!}
                {!! $errors->first('decline_reason', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
