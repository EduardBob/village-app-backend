<div class="box-body">
    <div class="row">
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group{{ $errors->has('service_id') ? ' has-error' : '' }}">
                    {!! Form::label('service_id', $admin->trans('table.service')) !!}
                    {!! Form::select('service_id', $admin->getServices(),
                    Input::old('service_id', @$model->service->id), ['class' => 'form-control', 'placeholder' => $admin->trans('form.service.placeholder')]) !!}
                    {!! $errors->first('service_id', '<span class="help-block">:message</span>') !!}
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                    {!! Form::label('user_id', $admin->trans('table.user')) !!}
                    {!! Form::select('user_id', (new Modules\Village\Entities\User)->getList(),
                    Input::old('user_id', @$model->user->id), ['class' => 'form-control', 'placeholder' => $admin->trans('form.user.placeholder')]) !!}
                    {!! $errors->first('user_id', '<span class="help-block">:message</span>') !!}
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group{{ $errors->has('perform_date') ? ' has-error' : '' }}">
                    {!! Form::label('perform_date', $admin->trans('table.perform_date')) !!}
                    {!! Form::text('perform_date', Input::old('perform_date', @$model->perform_date ? Carbon\Carbon::parse(@$model->perform_date)->format('Y-m-d') : ''), ['class' => 'js-date-field form-control']) !!}
                    {!! $errors->first('perform_date', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group{{ $errors->has('perform_time') ? ' has-error' : '' }}">
                    {!! Form::label('perform_time', $admin->trans('table.perform_time')) !!}
                    {!! Form::text('perform_time', Input::old('perform_time', @$model->perform_time), ['class' => 'js-time-field form-control']) !!}
                    {!! $errors->first('perform_time', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group{{ $errors->has('payment_type') ? ' has-error' : '' }}">
                    {!! Form::label('payment_type', $admin->trans('table.payment_type')) !!}
                    {!! Form::select('payment_type', array_combine(config('village.order.payment.type.values'), $admin->trans('form.payment.type.values')),
                    Input::old('payment_type', @$model->payment_type), ['class' => 'form-control', 'placeholder' => $admin->trans('form.payment.type.placeholder')]) !!}
                    {!! $errors->first('payment_type', '<span class="help-block">:message</span>') !!}
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group{{ $errors->has('payment_status') ? ' has-error' : '' }}">
                    {!! Form::label('payment_status', $admin->trans('table.payment_status')) !!}
                    {!! Form::select('payment_status', array_combine(config('village.order.payment.status.values'), $admin->trans('form.payment.status.values')),
                    Input::old('payment_status', @$model->payment_status), ['class' => 'form-control', 'placeholder' => $admin->trans('form.payment.status.placeholder')]) !!}
                    {!! $errors->first('payment_status', '<span class="help-block">:message</span>') !!}
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
            <?php endif; ?>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                    {!! Form::label('comment', $admin->trans('table.comment')) !!}
                    {!! Form::textarea('comment', Input::old('comment', @$model->comment), ['class' => 'form-control']) !!}
                    {!! $errors->first('comment', '<span class="help-block">:message</span>') !!}
                </div>
            </div>

            <?php if (isset($model)): ?>
            <div class="col-sm-4">
                <div class="form-group{{ $errors->has('decline_reason') ? ' has-error' : '' }}">
                    {!! Form::label('decline_reason', $admin->trans('table.decline_reason')) !!}
                    {!! Form::textarea('decline_reason', Input::old('decline_reason', @$model->decline_reason), ['class' => 'form-control']) !!}
                    {!! $errors->first('decline_reason', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-sm-7">
                @include('media::admin.fields.file-link-multiple', [
                    'entityClass' => 'Modules\\\\Village\\\\Entities\\\\ServiceOrder',
                    'entityId' =>  @$model->id,
                    'zone' => 'media',
                    'mediaFiles' => @$model->files,
                    'thumbnail' => 'biggerThumb'
                ])
            </div>
            <?php endif; ?>
        </div>
        <?php if (isset($model) && \Modules\Village\Entities\Service::TYPE_SC === $model->service->type): ?>
            <div class="row">
                <div class="col-sm-12">Дополнительные поля заявки на пропуск заполняемые охранником:</div>
                <div class="col-sm-4">
                    <div class="form-group{{ $errors->has('admin_comment') ? ' has-error' : '' }}">
                        {!! Form::label('admin_comment', $admin->trans('table.admin_comment')) !!}
                        {!! Form::textarea('admin_comment', Input::old('admin_comment', @$model->admin_comment), ['class' => 'form-control']) !!}
                        {!! $errors->first('admin_comment', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
