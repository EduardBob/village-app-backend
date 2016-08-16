<div class="box-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('created_at', $admin->trans('table.created_at')) !!}
                <div>{{ Carbon\Carbon::parse(@$model->created_at)->format('d.m.Y H:i:s') }}</div>
            </div>
        </div>
    </div>
    @if(($currentUser->inRole('admin') || $currentUser->inRole('village-admin')) && $model->product->executor)
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('product_executor_id', trans('village::products.table.executor')) !!}
                <div>{{ $model->product->executor->last_name }} {{ $model->product->executor->first_name }}</div>
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
    @if($model->perform_date)
    <div class="row">
        <div class="col-sm-12">
        	<div class="form-group">
        	    {!! Form::label('perform_date', $admin->trans('table.perform_date')) !!}
        	    <div>{{ Carbon\Carbon::parse(@$model->perform_date)->format('d.m.Y') }} {{ $model->perform_time }}</div>
        	</div>
        </div>
    </div>
    @endif
    @if($model->done_at)
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    {!! Form::label('done_at', $admin->trans('table.done_at')) !!}
                    <div>{{ Carbon\Carbon::parse(@$model->done_at)->format('d.m.Y H:i:s') }}</div>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('product_id', $admin->trans('table.product')) !!}
                <div>{{ $model->product->title }}</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('unit_price', $admin->trans('table.unit_price')) !!}
                <div>{{ $model->unit_price }}</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-1">
        	<div class="form-group">
        	    <?php $unitTitles = array_combine(config('village.product.unit.values'), $admin->trans('form.unit_title.values')) ?>
        	    {!! Form::label('quantity', $admin->trans('table.quantity')) !!}
        	    <div>{{ $model->quantity }} {{ $unitTitles[$model->unit_title] }}</div>
        	</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
        	<div class="form-group">
        	    {!! Form::label('price', $admin->trans('table.price')) !!}
        	    <div>{{ $model->unit_price }} x {{ $model->quantity }} = {{ $model->price }}</div>
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
