@extends($admin->getView('show', 'admin'))

@section('buttons')
    @parent

    @if($currentUser && $currentUser->hasAccess('village.services.baseCopy'))
        @if($currentUser->inRole('admin'))
            {!! Form::open(['route' => ['admin.village.service.baseCopy', $model->id], 'method' => 'get']) !!}
                <button type="submit" class="btn pull-left">{{ $admin->trans('button.base-copy') }}</button>
            {!! Form::close() !!}
        @elseif(!$currentUser->inRole('admin') && $currentUser->village)
            <?php $service = (new \Modules\Village\Entities\Service)->findOneByVillageAndBaseId($currentUser->village, $model->id); ?>
            @if($service)
                <a class="btn pull-left" href="{{ route('admin.village.service.edit', ['id' => $service->id]) }}">У вас уже есть эта услуга</a>
            @else
                {!! Form::open(['route' => ['admin.village.service.baseCopy', $model->id], 'method' => 'get']) !!}
                    <button type="submit" class="btn pull-left">{{ $admin->trans('button.base-copy') }}</button>
                {!! Form::close() !!}
            @endif
        @endif
    @endif
@stop