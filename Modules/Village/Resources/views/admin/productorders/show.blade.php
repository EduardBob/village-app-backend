@extends($admin->getView('show', 'admin'))

@section('buttons')
    @parent


    @if($currentUser && $currentUser->hasAccess($admin->getAccess('edit')))
        {!! Form::open(['route' => [$admin->getRoute('edit'), $model->id], 'method' => 'get']) !!}
        <button type="submit" class="btn pull-left">{{ $admin->trans('button.edit') }}</button>
        {!! Form::close() !!}
        <span class="pull-left">&nbsp;&nbsp;&nbsp;</span>
    @endif
    @if($model->status == 'processing' && $currentUser->hasAccess($admin->getAccess('setStatusRunning')))
        {!! Form::open(['route' => [$admin->getRoute('set_status_running'), $model->id], 'method' => 'put']) !!}
        <button type="submit" class="btn pull-left btn-flat label-waring">{{ $admin->trans('button.status_running') }}</button>
        {!! Form::close() !!}
        <span class="pull-left">&nbsp;&nbsp;&nbsp;</span>
    @endif
    @if($model->status == $model::STATUS_RUNNING && $currentUser->hasAccess($admin->getAccess('setStatusDone')))
        {!! Form::open(['route' => [$admin->getRoute('set_status_done'), $model->id], 'method' => 'put']) !!}
        <button type="submit" class="btn pull-left btn-flat label-success">
            {{ $admin->trans('button.status_done') }}
        </button>
        {!! Form::close() !!}
        <span class="pull-left">&nbsp;&nbsp;&nbsp;</span>
    @endif
    @if($model->payment_status !== $model::PAYMENT_STATUS_PAID && $currentUser->hasAccess($admin->getAccess('setPaymentDone')))
        {!! Form::open(['route' => [$admin->getRoute('set_payment_done'), $model->id], 'method' => 'put']) !!}
        <button type="submit" class="btn pull-left btn-flat label-success">
            {{ $admin->trans('button.payment_done') }}
        </button>
        {!! Form::close() !!}
        <span class="pull-left">&nbsp;&nbsp;&nbsp;</span>
    @endif
    @if($model->status == $model::STATUS_RUNNING && $currentUser->hasAccess($admin->getAccess('setStatusDone')) && $model->payment_status !== $model::PAYMENT_STATUS_PAID && $currentUser->hasAccess($admin->getAccess('setPaymentDone')))
        {!! Form::open(['route' => [$admin->getRoute('set_payment_and_status_done'), $model->id], 'method' => 'put']) !!}
        <button type="submit" class="btn pull-left btn-flat label-success">
            {{ $admin->trans('button.status_paid_and_done') }}
        </button>
        {!! Form::close() !!}
        <span class="pull-left">&nbsp;&nbsp;&nbsp;</span>
    @endif
@stop