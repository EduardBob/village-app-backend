@extends($admin->getView('show', 'admin'))

@section('buttons')
    @parent

    @if($currentUser && $currentUser->hasAccess('village.surveys.baseCopy'))
        {!! Form::open(['route' => ['admin.village.survey.baseCopy', $model->id], 'method' => 'get']) !!}
            <button type="submit" class="btn pull-left">{{ $admin->trans('button.base-copy') }}</button>
        {!! Form::close() !!}
    @endif
@stop