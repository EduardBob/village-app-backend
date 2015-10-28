<div class="box-body">
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
    <div class="row">
        <div class="col-sm-12">
        	<div class="form-group">
        	    {!! Form::label('perform_at', $admin->trans('table.perform_at')) !!}
        	    <div>{{ Carbon\Carbon::parse(@$model->perform_at)->format(config('village.date.format')) }}</div>
        	</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('product_id', $admin->trans('table.product')) !!}
                <div>{{ $model->product->title }}</div>
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
