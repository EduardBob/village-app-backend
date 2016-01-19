@extends('village::admin.admin.create')

@section('content-header')
    <h1>
        {{ trans('user::users.title.new-user') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('user::users.title.new-user') }}</li>
    </ol>
@stop

{{--{{ trans('core::core.button.create') }}--}}