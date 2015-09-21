<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                {!! Form::label('title', $admin->trans('table.title')) !!}
                {!! Form::text('title', Input::old('title', @$model->title), ['class' => 'form-control', 'placeholder' => $admin->trans('table.title')]) !!}
                {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-4">
        	<div class="form-group{{ $errors->has('ends_at') ? ' has-error' : '' }}">
        	    {!! Form::label('ends_at', $admin->trans('table.ends_at')) !!}
        	    {!! Form::text('ends_at', Input::old('ends_at', Carbon\Carbon::parse(@$model->ends_at)->format(config('village.date.format'))), ['class' => 'js-date-field form-control']) !!}
        	    {!! $errors->first('ends_at', '<span class="help-block">:message</span>') !!}
        	</div>
        </div>
    </div>
</div>
