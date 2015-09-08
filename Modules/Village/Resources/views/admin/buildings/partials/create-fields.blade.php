<div class="box-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                {!! Form::label('address', trans('village::buildings.form.address')) !!}
                {!! Form::text('address', Input::old('address'), ['class' => 'form-control', 'placeholder' => trans('village::buildings.form.address')]) !!}
                {!! $errors->first('address', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
</div>
