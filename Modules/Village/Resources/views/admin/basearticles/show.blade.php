@extends($admin->getView('show', 'admin'))

@section('buttons')
    @parent

    @if($currentUser && $currentUser->hasAccess('village.articles.baseCopy'))
				<button class="btn pull-left">
					<a href='{!! route('admin.village.article.baseCopy', [$model->id]) !!}'>{{ $admin->trans('button.base-copy') }}</a>
				</button>
    @endif
@stop