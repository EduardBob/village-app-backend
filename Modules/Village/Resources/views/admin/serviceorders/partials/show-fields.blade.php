<div class="box-body">
    @if(($currentUser->inRole('admin') || $currentUser->inRole('village-admin')) && $model->service->executor)
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('service_executor_id', trans('village::services.table.executor')) !!}
                <div>{{ $model->service->executor->last_name }} {{ $model->service->executor->first_name }}</div>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('user_id', $admin->trans('table.user')) !!}
                <div>{{ $model->user->last_name }} {{ $model->user->first_name }}</div>
            </div>
        </div>
    </div>
    @if(isset($model) && $model->perform_date)
    <div class="row">
        <div class="col-sm-12">
        	<div class="form-group">
        	    {!! Form::label('perform_date', $admin->trans('table.perform_date')) !!}
        	    <div>{{ Carbon\Carbon::parse(@$model->perform_date)->format(config('village.date.format')) }}</div>
        	</div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('service_id', $admin->trans('table.service')) !!}
                <div>{{ $model->service->title }}</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
        	<div class="form-group">
        	    {!! Form::label('price', $admin->trans('table.price')) !!}
        	    <div>{{ $model->price }}</div>
        	</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('comment', $admin->trans('table.comment')) !!}
                <div>{{ $model->comment }}</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('payment_type', $admin->trans('table.payment_type')) !!}
                <?php $statuses = array_combine(config('village.order.payment.type.values'), $admin->trans('form.payment.type.values')) ?>
                <div>{{ $statuses[$model->payment_type] }}</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('payment_status', $admin->trans('table.payment_status')) !!}
                <?php $statuses = array_combine(config('village.order.payment.status.values'), $admin->trans('form.payment.status.values')) ?>
                <div>{{ $statuses[$model->payment_status] }}</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('status', $admin->trans('table.status')) !!}
                <?php $statuses = array_combine(config('village.order.statuses'), $admin->trans('form.status.values')) ?>
                <div>{{ $statuses[$model->status] }}</div>
            </div>
        </div>
    </div>
    @if($model->decline_reason)
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('decline_reason', $admin->trans('table.decline_reason')) !!}
                <div>{{ $model->decline_reason }}</div>
            </div>
        </div>
    </div>
    @endif
</div>
