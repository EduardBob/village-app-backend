<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('product_id') ? ' has-error' : '' }}">
                {!! Form::label('product_id', $admin->trans('table.product')) !!}
                {!! Form::select('product_id', (new Modules\Village\Entities\Product)->lists('title', 'id'),
                Input::old('product_id', @$model->product->id), ['class' => 'form-control', 'placeholder' => $admin->trans('form.product.placeholder')]) !!}
                {!! $errors->first('product_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                {!! Form::label('user_id', $admin->trans('table.user')) !!}
                {!! Form::select('user_id', (new Modules\Village\Entities\User)->getList(),
                Input::old('user_id', @$model->user->id), ['class' => 'form-control', 'placeholder' => $admin->trans('form.user.placeholder')]) !!}
                {!! $errors->first('user_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>

        <div class="col-sm-3">
        	<div class="form-group{{ $errors->has('perform_at') ? ' has-error' : '' }}">
        	    {!! Form::label('perform_at', $admin->trans('table.perform_at')) !!}
        	    {!! Form::text('perform_at', Input::old('perform_at', Carbon\Carbon::parse(@$model->perform_at)->format(config('village.date.format'))), ['class' => 'js-date-field form-control']) !!}
        	    {!! $errors->first('perform_at', '<span class="help-block">:message</span>') !!}
        	</div>
        </div>

        <div class="col-sm-1">
        	<div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
        	    {!! Form::label('quantity', $admin->trans('table.quantity')) !!}
        	    {!! Form::text('quantity', Input::old('quantity', @$model->quantity), ['class' => 'form-control']) !!}
        	    {!! $errors->first('quantity', '<span class="help-block">:message</span>') !!}
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
