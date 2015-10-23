<div class="box-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', $admin->trans('table.name')) !!}
                {!! Form::text('name', Input::old('name', @$model->name), ['class' => 'form-control', 'placeholder' => $admin->trans('table.name')]) !!}
                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('shop_name') ? ' has-error' : '' }}">
                {!! Form::label('shop_name', $admin->trans('table.shop_name')) !!}
                {!! Form::text('shop_name', Input::old('shop_name', @$model->shop_name), ['class' => 'form-control', 'placeholder' => $admin->trans('table.shop_name')]) !!}
                {!! $errors->first('shop_name', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('shop_address') ? ' has-error' : '' }}">
                {!! Form::label('shop_address', $admin->trans('table.shop_address')) !!}
                {!! Form::text('shop_address', Input::old('shop_address', @$model->shop_address), ['class' => 'form-control', 'placeholder' => $admin->trans('table.shop_address')]) !!}
                {!! $errors->first('shop_address', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('service_payment_info') ? ' has-error' : '' }}">
                {!! Form::label('service_payment_info', $admin->trans('table.service_payment_info')) !!}
                {!! Form::text('service_payment_info', Input::old('service_payment_info', @$model->service_payment_info), ['class' => 'form-control', 'placeholder' => $admin->trans('table.service_payment_info')]) !!}
                {!! $errors->first('service_payment_info', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('service_bottom_text') ? ' has-error' : '' }}">
                {!! Form::label('service_bottom_text', $admin->trans('table.service_bottom_text')) !!}
                {!! Form::text('service_bottom_text', Input::old('service_bottom_text', @$model->service_bottom_text), ['class' => 'form-control', 'placeholder' => $admin->trans('table.service_bottom_text')]) !!}
                {!! $errors->first('service_bottom_text', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('product_payment_info') ? ' has-error' : '' }}">
                {!! Form::label('product_payment_info', $admin->trans('table.product_payment_info')) !!}
                {!! Form::text('product_payment_info', Input::old('product_payment_info', @$model->product_payment_info), ['class' => 'form-control', 'placeholder' => $admin->trans('table.product_payment_info')]) !!}
                {!! $errors->first('product_payment_info', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('product_bottom_text') ? ' has-error' : '' }}">
                {!! Form::label('product_bottom_text', $admin->trans('table.product_bottom_text')) !!}
                {!! Form::text('product_bottom_text', Input::old('product_bottom_text', @$model->product_bottom_text), ['class' => 'form-control', 'placeholder' => $admin->trans('table.product_bottom_text')]) !!}
                {!! $errors->first('product_bottom_text', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('product_unit_step_kg') ? ' has-error' : '' }}">
                {!! Form::label('product_unit_step_kg', $admin->trans('table.product_unit_step_kg')) !!}
                {!! Form::text('product_unit_step_kg', Input::old('product_unit_step_kg', @$model->product_unit_step_kg), ['class' => 'form-control', 'placeholder' => $admin->trans('table.product_unit_step_kg')]) !!}
                {!! $errors->first('product_unit_step_kg', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('product_unit_step_bottle') ? ' has-error' : '' }}">
                {!! Form::label('product_unit_step_bottle', $admin->trans('table.product_unit_step_bottle')) !!}
                {!! Form::text('product_unit_step_bottle', Input::old('product_unit_step_bottle', @$model->product_unit_step_bottle), ['class' => 'form-control', 'placeholder' => $admin->trans('table.product_unit_step_bottle')]) !!}
                {!! $errors->first('product_unit_step_bottle', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('product_unit_step_piece') ? ' has-error' : '' }}">
                {!! Form::label('product_unit_step_piece', $admin->trans('table.product_unit_step_piece')) !!}
                {!! Form::text('product_unit_step_piece', Input::old('product_unit_step_piece', @$model->product_unit_step_piece), ['class' => 'form-control', 'placeholder' => $admin->trans('table.product_unit_step_piece')]) !!}
                {!! $errors->first('product_unit_step_piece', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                {!! Form::label('active', $admin->trans('table.active')) !!}
                {!! Form::checkbox('active', (int)Input::old('active', @$model->active), (bool)Input::old('active', @$model->active), ['class' => 'flat-blue']) !!}
                {!! $errors->first('active', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
</div>
