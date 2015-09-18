<div class="box-body">
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group{{ $errors->has('product') ? ' has-error' : '' }}">
                {!! Form::label('product', $admin->trans('table.product')) !!}
                {!! Form::select('product', (new Modules\Village\Entities\Product)->lists('title', 'id'),
                Input::old('product'), ['class' => 'form-control', 'placeholder' => $admin->trans('form.product.placeholder')]) !!}
                {!! $errors->first('product', '<span class="help-block">:message</span>') !!}
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group{{ $errors->has('profile') ? ' has-error' : '' }}">
                {!! Form::label('profile', $admin->trans('table.profile')) !!}
                {!! Form::select('profile', (new Modules\Village\Entities\Profile)->getList(),
                Input::old('profile'), ['class' => 'form-control', 'placeholder' => $admin->trans('form.profile.placeholder')]) !!}
                {!! $errors->first('profile', '<span class="help-block">:message</span>') !!}
            </div>
        </div>

        <div class="col-sm-3">
        	<div class="form-group{{ $errors->has('perform_at') ? ' has-error' : '' }}">
        	    {!! Form::label('perform_at', $admin->trans('table.perform_at')) !!}
        	    {!! Form::text('perform_at', Input::old('perform_at'), ['class' => 'js-date-field form-control']) !!}
        	    {!! $errors->first('perform_at', '<span class="help-block">:message</span>') !!}
        	</div>
        </div>

        <div class="col-sm-3">
        	<div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
        	    {!! Form::label('quantity', $admin->trans('table.quantity')) !!}
        	    {!! Form::text('quantity', Input::old('quantity'), ['class' => 'form-control']) !!}
        	    {!! $errors->first('quantity', '<span class="help-block">:message</span>') !!}
        	</div>
        </div>
    </div>
</div>
