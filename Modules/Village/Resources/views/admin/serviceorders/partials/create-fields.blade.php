<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('service') ? ' has-error' : '' }}">
                {!! Form::label('service', trans('village::serviceorders.table.service')) !!}
                {!! Form::select('service', (new Modules\Village\Entities\Service)->getAll(),
                Input::old('service'), ['class' => 'form-control']) !!}
                {!! $errors->first('service', '<span class="help-block">'.trans('village::serviceorders.validation.service').'</span>') !!}
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('profile') ? ' has-error' : '' }}">
                {!! Form::label('profile', trans('village::serviceorders.table.profile')) !!}
                {!! Form::select('profile', (new Modules\Village\Entities\Profile)->getAll(),
                Input::old('profile'), ['class' => 'form-control']) !!}
                {!! $errors->first('profile', '<span class="help-block">'.trans('village::serviceorders.validation.profile').'</span>') !!}
            </div>
        </div>

        <div class="col-sm-4">
        	<div class="form-group{{ $errors->has('perform_at') ? ' has-error' : '' }}">
        	    {!! Form::label('perform_at', trans('village::serviceorders.table.perform_at')) !!}
        	    {!! Form::text('perform_at', Input::old('perform_at'), ['class' => 'js-date-field form-control']) !!}
        	    {!! $errors->first('perform_at', '<span class="help-block">'.trans('village::serviceorders.validation.perform_at').'</span>') !!}
        	</div>
        </div>
    </div>
</div>
