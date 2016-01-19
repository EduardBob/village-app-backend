<div class="box-body">
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
        </div>
        @endif
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
