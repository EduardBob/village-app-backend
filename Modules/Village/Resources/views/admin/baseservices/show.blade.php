@extends($admin->getView('show', 'admin'))

@section('buttons')
    @parent

    @if($currentUser && $currentUser->hasAccess('village.services.baseCopy'))
        @if($currentUser->inRole('admin'))
						<button class="btn pull-left">
							<a href='{!! route('admin.village.service.baseCopy', [$model->id]) !!}'>{{ $admin->trans('button.base-copy') }}</a>
						</button>
        @elseif(!$currentUser->inRole('admin') && $currentUser->village)
            <?php $service = (new \Modules\Village\Entities\Service)->findOneByVillageAndBaseId($currentUser->village, $model->id); ?>
            @if($service)
                <a class="btn pull-left" href="{{ route('admin.village.service.edit', ['id' => $service->id]) }}">У вас уже есть эта услуга</a>
            @else
								<button class="btn pull-left">
									<a href='{!! route('admin.village.service.baseCopy', [$model->id]) !!}'>{{ $admin->trans('button.base-copy') }}</a>
								</button>
            @endif
        @endif
    @endif
@stop