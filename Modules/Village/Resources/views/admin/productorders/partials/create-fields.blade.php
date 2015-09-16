<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('product') ? ' has-error' : '' }}">
                {!! Form::label('product', trans('village::productorders.table.product')) !!}
                {!! Form::select('product', (new Modules\Village\Entities\Product)->getAll(),
                Input::old('product'), ['class' => 'form-control']) !!}
                {!! $errors->first('product', '<span class="help-block">'.trans('village::productorders.validation.product').'</span>') !!}
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('profile') ? ' has-error' : '' }}">
                {!! Form::label('profile', trans('village::productorders.table.profile')) !!}
                {!! Form::select('profile', (new Modules\Village\Entities\Profile)->getAll(),
                Input::old('profile'), ['class' => 'form-control']) !!}
                {!! $errors->first('profile', '<span class="help-block">'.trans('village::productorders.validation.profile').'</span>') !!}
            </div>
        </div>

        <div class="col-sm-3">
        	<div class="form-group{{ $errors->has('perform_at') ? ' has-error' : '' }}">
        	    {!! Form::label('perform_at', trans('village::productorders.table.perform_at')) !!}
        	    {!! Form::text('perform_at', Input::old('perform_at'), ['class' => 'js-date-field form-control']) !!}
        	    {!! $errors->first('perform_at', '<span class="help-block">'.trans('village::productorders.validation.perform_at').'</span>') !!}
        	</div>
        </div>

        <div class="col-sm-1">
        	<div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
        	    {!! Form::label('quantity', trans('village::productorders.table.quantity')) !!}
        	    {!! Form::text('quantity', Input::old('quantity'), ['class' => 'form-control']) !!}
        	    {!! $errors->first('quantity', '<span class="help-block">:message</span>') !!}
        	</div>
        </div>
    </div>
</div>
