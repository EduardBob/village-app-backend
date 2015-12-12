@extends('village::admin.admin.index')

@section('content-header')
    <h1>
        {{ trans('user::users.title.users') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        {{--<li class="active">{{ $admin->trans('title.module') }}</li>--}}
        <li class="active">{{ trans('user::users.breadcrumb.users') }}</li>
    </ol>
@stop