@extends($admin->getView('show', 'admin'))

@section('buttons')
    @parent

    @if($currentUser && $currentUser->hasAccess('village.products.baseCopy'))
				<button class="btn pull-left">
					<a href='{!! route('admin.village.product.baseCopy', [$model->id]) !!}'>{{ $admin->trans('button.base-copy') }}</a>
				</button>
    @endif
@stop