<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('service') ? ' has-error' : '' }}">
                {!! Form::label('service', $admin->trans('table.service')) !!}
                {!! Form::select('service', (new Modules\Village\Entities\Service)->lists('title', 'id'),
                Input::old('service'), ['class' => 'form-control', 'placeholder' => $admin->trans('form.service.placeholder')]) !!}
                {!! $errors->first('service', '<span class="help-block">:message</span>') !!}
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('profile') ? ' has-error' : '' }}">
                {!! Form::label('profile', $admin->trans('table.profile')) !!}
                {!! Form::select('profile', (new Modules\Village\Entities\Profile)->getList(),
                Input::old('profile'), ['class' => 'form-control', 'placeholder' => $admin->trans('form.profile.placeholder')]) !!}
                {!! $errors->first('profile', '<span class="help-block">:message</span>') !!}
            </div>
        </div>

        <div class="col-sm-4">
        	<div class="form-group{{ $errors->has('perform_at') ? ' has-error' : '' }}">
        	    {!! Form::label('perform_at', $admin->trans('table.perform_at')) !!}
        	    {!! Form::text('perform_at', Input::old('perform_at'), ['class' => 'js-date-field form-control']) !!}
        	    {!! $errors->first('perform_at', '<span class="help-block">:message</span>') !!}
        	</div>
        </div>
    </div>
</div>
