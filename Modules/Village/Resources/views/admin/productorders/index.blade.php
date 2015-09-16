@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('village::productorders.title.productorders') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('village::productorders.title.productorders') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.village.productorder.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('village::productorders.button.create productorder') }}
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
                            <th>{{ trans('village::productorders.table.product') }}</th>
                            <th>{{ trans('village::productorders.table.quantity') }}</th>
                            <th>{{ trans('village::productorders.table.address') }}</th>
                            <th>{{ trans('village::productorders.table.perform_at') }}</th>
                            <th>{{ trans('village::productorders.table.price') }}</th>
                            <th>{{ trans('village::productorders.table.name') }}</th>
                            <th>{{ trans('village::productorders.table.phone') }}</th>
                            <th>{{ trans('village::productorders.table.status') }}</th>
                            <th>{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($productOrders)): ?>
                        <?php foreach ($productOrders as $productOrder): ?>
                        <tr>
                            <td>
                                <a href="{{ route('admin.village.product.edit', [$productOrder->product->id]) }}">
                                    {{ $productOrder->product->title }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.village.productorder.edit', [$productOrder->id]) }}">
                                    {{ $productOrder->quantity }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.user.user.edit', [$productOrder->profile->user->id]) }}">
                                    {{ $productOrder->profile->building->address }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.village.productorder.edit', [$productOrder->id]) }}">
                                    {!! Carbon\Carbon::parse($productOrder->perform_at)->format(config('village.dateFormat')) !!}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.village.productorder.edit', [$productOrder->id]) }}">
                                    {{ $productOrder->price }}
                                </a>
                            </td>
                            <td>
                                @if ($productOrder->profile)
                                    <a href="{{ route('admin.user.user.edit', [$productOrder->profile->user->id]) }}">
                                        {{ $productOrder->profile->user->first_name }} {{ $productOrder->profile->user->last_name }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if ($productOrder->profile)
                                    <a href="{{ route('admin.user.user.edit', [$productOrder->profile->user->id]) }}">
                                        {{ $productOrder->profile->phone }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.village.productorder.edit', [$productOrder->id]) }}">
                                    {{ $productOrder->status }}
                                </a>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.village.productorder.edit', [$productOrder->id]) }}" class="btn btn-default btn-flat"><i class="glyphicon glyphicon-pencil"></i></a>
                                    <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#confirmation-{{ $productOrder->id }}"><i class="glyphicon glyphicon-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>{{ trans('village::productorders.table.product') }}</th>
                            <th>{{ trans('village::productorders.table.quantity') }}</th>
                            <th>{{ trans('village::productorders.table.address') }}</th>
                            <th>{{ trans('village::productorders.table.perform_at') }}</th>
                            <th>{{ trans('village::productorders.table.price') }}</th>
                            <th>{{ trans('village::productorders.table.name') }}</th>
                            <th>{{ trans('village::productorders.table.phone') }}</th>
                            <th>{{ trans('village::productorders.table.status') }}</th>
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
    <?php if (isset($productOrders)): ?>
    <?php foreach ($productOrders as $productOrder): ?>
    <!-- Modal -->
    <div class="modal fade modal-danger" id="confirmation-{{ $productOrder->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                    {!! Form::open(['route' => ['admin.village.productorder.destroy', $productOrder->id], 'method' => 'delete', 'class' => 'pull-left']) !!}
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
        <dd>{{ trans('village::productorders.title.create productorder') }}</dd>
    </dl>
@stop

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.village.productorder.create') ?>" }
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
                    null,
                    { "sortable": false }
                ]
            });
        });
    </script>
@stop
