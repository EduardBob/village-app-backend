<div class="box-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                {!! Form::label('address', $admin->trans('table.address')) !!}
                {!! Form::text('address', Input::old('address', @$model->address), ['class' => 'form-control', 'placeholder' => $admin->trans('form.address')]) !!}
                {!! $errors->first('address', '<span class="help-block">:message</span>') !!}
            </div>
        </div>

        <?php if (isset($model)): ?>
        <div class="col-sm-4">
        	<div class="form-group">
	        	{!! Form::label('null', $admin->trans('table.code')) !!}
        		{!! Form::text('null', @$model->code, ['class' => 'form-control', 'readonly' => true]) !!}
        	</div>
        </div>
        <?php endif; ?>
    </div>
</div>
