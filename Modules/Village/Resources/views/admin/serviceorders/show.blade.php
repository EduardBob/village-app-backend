@extends($admin->getView('show', 'admin'))

@section('buttons')
    @parent

    @if($currentUser->hasAccess($admin->getAccess('edit')))
        {!! Form::open(['route' => [$admin->getRoute('edit'), $model->id], 'method' => 'get']) !!}
            <button type="submit" class="btn pull-left">{{ $admin->trans('button.edit') }}</button>
        {!! Form::close() !!}
    @endif
    @if($model->status == 'processing' && $currentUser->hasAccess($admin->getAccess('setStatusRunning')))
        {!! Form::open(['route' => [$admin->getRoute('set_status_running'), $model->id], 'method' => 'put']) !!}
            <button type="submit" class="btn pull-left btn-flat label-waring">{{ $admin->trans('button.status_running') }}</button>
        {!! Form::close() !!}
    @endif
    @if($model->status == 'running' && $currentUser->hasAccess($admin->getAccess('setStatusDone')))
        {!! Form::open(['route' => [$admin->getRoute('set_status_done'), $model->id], 'method' => 'put']) !!}
            <button type="submit" class="btn pull-left btn-flat label-success">{{ $admin->trans('button.status_done') }}</button>
        {!! Form::close() !!}
    @endif
@stop