@extends($admin->getView('form'))

@section('content-header')
    <h1>
        {{ $admin->trans('title.create') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ $admin->route('index') }}">{{ $admin->trans('title.module') }}</a></li>
        <li class="active">{{ $admin->trans('title.create') }}</li>
    </ol>
@stop

@section('content')
    {!! Form::open(['route' => [$admin->getRoute('store')], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include($admin->getView('partials.create-fields'), ['lang' => $locale])
                        </div>
                    @endforeach

                    <div class="box-footer">
                        @if($currentUser->hasAccess($admin->getAccess('create')))
                            <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
                        @endif
                        <a class="btn btn-danger pull-right btn-flat" href="{{ $admin->route('index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>
    {!! Form::close() !!}
@stop
