@extends($admin->getView('form'))

@section('content-header')
    <h1>
        {{ $admin->trans('title.show') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ $admin->route('index') }}">{{ $admin->trans('title.module') }}</a></li>
        <li class="active">{{ $admin->trans('title.show') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include($admin->getView('partials.show-fields'), ['lang' => $locale])
                        </div>
                    @endforeach

                    <div class="box-footer clearfix">
                        @yield('buttons')
                        <a class="btn btn-danger pull-right btn-flat" href="{{ $admin->route('index')}}"><i class="fa fa-times"></i> {{ $admin->trans('button.index') }}</a>
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>
@stop
