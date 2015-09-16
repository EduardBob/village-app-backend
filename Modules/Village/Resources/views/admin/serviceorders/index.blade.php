@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('village::serviceorders.title.serviceorders') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('village::serviceorders.title.serviceorders') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.village.serviceorder.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('village::serviceorders.button.create serviceorder') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>{{ trans('village::serviceorders.table.service') }}</th>
                            <th>{{ trans('village::serviceorders.table.perform_at') }}</th>
                            <th>{{ trans('village::serviceorders.table.address') }}</th>
                            <th>{{ trans('village::serviceorders.table.name') }}</th>
                            <th>{{ trans('village::serviceorders.table.phone') }}</th>
                            <th>{{ trans('village::serviceorders.table.price') }}</th>
                            <th>{{ trans('village::serviceorders.table.status') }}</th>
                            <th>{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($serviceOrders)): ?>
                        <?php foreach ($serviceOrders as $serviceOrder): ?>
                        <tr>
                            <td>
                                <a href="{{ route('admin.village.service.edit', [$serviceOrder->service->id]) }}">
                                    {{ $serviceOrder->service->title }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.village.serviceorder.edit', [$serviceOrder->id]) }}">
                                    {!! Carbon\Carbon::parse($serviceOrder->perform_at)->format(config('village.dateFormat')) !!}
                                </a>
                            </td>
                            <td>
                                @if ($serviceOrder->profile && $serviceOrder->profile->building)
                                    <a href="{{ route('admin.village.building.edit', [$serviceOrder->profile->building->id]) }}">
                                        {{ $serviceOrder->profile->building->address }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if ($serviceOrder->profile)
                                    <a href="{{ route('admin.user.user.edit', [$serviceOrder->profile->user->id]) }}">
                                        {{ $serviceOrder->profile->user->first_name }} {{ $serviceOrder->profile->user->last_name }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if ($serviceOrder->profile)
                                    <a href="{{ route('admin.user.user.edit', [$serviceOrder->profile->user->id]) }}">
                                        {{ $serviceOrder->profile->phone }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.village.service.edit', [$serviceOrder->service->id]) }}">
                                    {{ $serviceOrder->service()->first()->price }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.village.serviceorder.edit', [$serviceOrder->id]) }}">
                                    {{ $serviceOrder->status }}
                                </a>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.village.serviceorder.edit', [$serviceOrder->id]) }}" class="btn btn-default btn-flat"><i class="glyphicon glyphicon-pencil"></i></a>
                                    <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#confirmation-{{ $serviceOrder->id }}"><i class="glyphicon glyphicon-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>{{ trans('village::serviceorders.table.service') }}</th>
                            <th>{{ trans('village::serviceorders.table.perform_at') }}</th>
                            <th>{{ trans('village::serviceorders.table.address') }}</th>
                            <th>{{ trans('village::serviceorders.table.name') }}</th>
                            <th>{{ trans('village::serviceorders.table.phone') }}</th>
                            <th>{{ trans('village::serviceorders.table.price') }}</th>
                            <th>{{ trans('village::serviceorders.table.status') }}</th>
                            <th>{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </tfoot>
                    </table>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    <?php if (isset($serviceOrders)): ?>
    <?php foreach ($serviceOrders as $serviceOrder): ?>
    <!-- Modal -->
    <div class="modal fade modal-danger" id="confirmation-{{ $serviceOrder->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ trans('core::core.modal.title') }}</h4>
                </div>
                <div class="modal-body">
                    {{ trans('core::core.modal.confirmation-message') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline btn-flat" data-dismiss="modal">{{ trans('core::core.button.cancel') }}</button>
                    {!! Form::open(['route' => ['admin.village.serviceorder.destroy', $serviceOrder->id], 'method' => 'delete', 'class' => 'pull-left']) !!}
                    <button type="submit" class="btn btn-outline btn-flat"><i class="glyphicon glyphicon-trash"></i> {{ trans('core::core.button.delete') }}</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('village::serviceorders.title.create serviceorder') }}</dd>
    </dl>
@stop

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.village.serviceorder.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                },
                "columns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    { "sortable": false }
                ]
            });
        });
    </script>
@stop
