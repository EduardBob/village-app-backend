<script type="text/javascript" src={{ URL::asset('custom/js/moment.min.js') }}></script>
<script type="text/javascript" src={{ URL::asset('custom/js/bootstrap-datetimepicker.min.js') }}></script>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('custom/css/bootstrap-datetimepicker.css') }}">

<script>
    $(document).ready(function () {
        $('.js-date-time-field').datetimepicker({
            minDate: new Date(),
            useCurrent: false,
            sideBySide: true,
            format: 'DD-MM-YYYY HH:mm',
            locale: '{{App::getLocale()}}',
        });
    });
</script>


<div class="box-body">
    <div class="row">
        @if($currentUser && $currentUser->inRole('admin'))
            <div class="col-sm-12">
                <div class="form-group{{ $errors->has('main_admin_id') ? ' has-error' : '' }}">
                    {!! Form::label('main_admin_id', $admin->trans('table.main_admin_id')) !!}
                    {!! Form::select('main_admin_id', (new Modules\Village\Entities\User)->getVillageAdminList(),
                    Input::old('main_admin_id', @$model->main_admin_id), ['class' => 'form-control', 'placeholder' => $admin->trans('form.main_admin.placeholder')]) !!}
                    <p class="help-block">{{ $admin->trans('form.main_admin.help') }}</p>
                    {!! $errors->first('main_admin_id', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
		    <?php $types =  \Modules\Village\Entities\Village::getTypes(); ?>
            @if (isset($model))
                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                        {!! Form::label('type', 'Тип пакета')  !!}
                        {!! Form::select('type', array_combine(array_values($types), array_values($types)),
                        Input::old('type', @$model->type), ['class' => 'form-control', 'placeholder' => $admin->trans('form.main_admin.placeholder')]) !!}
                        {{--<p class="help-block">{{ $admin->trans('form.main_admin.help') }}</p>--}}
                        {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('packet') ? ' has-error' : '' }}">
                        {!! Form::label('packet', $admin->trans('table.packet')) !!}
                        {!! Form::select('packet', $model->getPackets(),
                        @$model->packet?:Input::old('packet'), ['class' => 'form-control'], '') !!}
                        {!! $errors->first('packet', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            @else
                <div class="col-sm-12">
                    <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                        {!! Form::label('type', 'Тип пакета')  !!}
                        {!! Form::select('type', array_combine(array_values($types), array_values($types)),
                        Input::old('type', @$model->type), ['class' => 'form-control', 'placeholder' => $admin->trans('form.main_admin.placeholder')]) !!}
                        <p class="help-block">{{ $admin->trans('form.main_admin.help') }}</p>
                        {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            @endif
            <div class="col-sm-4">
                <div class="form-group{{ $errors->has('balance') ? ' has-error' : '' }}">
                    {!! Form::label('balance', $admin->trans('table.balance')) !!}
                    {!! Form::number('balance', Input::old('balance', @$model->balance), ['class' => 'form-control', 'placeholder' => $admin->trans('table.balance')]) !!}
                    {!! $errors->first('balance', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group{{ $errors->has('payed_until') ? ' has-error' : '' }}">
                    {!! Form::label('payed_until', $admin->trans('table.payed_until')) !!}
                    {!! Form::text('payed_until', localizeddate(@$model->payed_until, 'medium_short') ? : localizeddate('now', 'medium_short')
                     , ['class' => 'form-control js-date-time-field', 'placeholder' => localizeddate('now', 'medium_short')]) !!}
                    {!! $errors->first('payed_until', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        @endif
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
	    <div class="col-sm-12">
		    <div class="form-group{{ $errors->has('link') ? ' has-error' : '' }}">
			    {!! Form::label('link', $admin->trans('table.link')) !!}
			    {!! Form::text('link', Input::old('link', @$model->link), ['class' => 'form-control', 'placeholder' => $admin->trans('table.link')]) !!}
			    {!! $errors->first('link', '<span class="help-block">:message</span>') !!}
		    </div>
	    </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('send_sms_to_village_admin') ? ' has-error' : '' }}">
                {!! Form::checkbox('send_sms_to_village_admin', (int)Input::old('send_sms_to_village_admin', @$model->send_sms_to_village_admin), (bool)Input::old('send_sms_to_village_admin', @$model->send_sms_to_village_admin), ['class' => 'flat-blue']) !!}
                {!! Form::label('send_sms_to_village_admin', $admin->trans('table.send_sms_to_village_admin')) !!}
                {!! $errors->first('send_sms_to_village_admin', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('send_sms_to_executor') ? ' has-error' : '' }}">
                {!! Form::checkbox('send_sms_to_executor', (int)Input::old('send_sms_to_executor', @$model->send_sms_to_executor), (bool)Input::old('send_sms_to_executor', @$model->send_sms_to_executor), ['class' => 'flat-blue']) !!}
                {!! Form::label('send_sms_to_executor', $admin->trans('table.send_sms_to_executor')) !!}
                {!! $errors->first('send_sms_to_executor', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                {!! Form::label('important_contacts', $admin->trans('table.important_contacts')) !!}
                {!! Form::textarea('important_contacts', Input::old('text', @$model->important_contacts), ['class' => 'form-control  ckeditor', 'placeholder' => $admin->trans('table.text')]) !!}
                {!! $errors->first('text', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                {!! Form::checkbox('active', (int)Input::old('active', @$model->active), (bool)Input::old('active', @$model->active), ['class' => 'flat-blue']) !!}
                {!! Form::label('active', $admin->trans('table.active')) !!}
                {!! $errors->first('active', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
</div>