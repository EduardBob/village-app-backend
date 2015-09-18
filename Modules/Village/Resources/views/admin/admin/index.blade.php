@extends($admin->getView('layout'))

@section('content-header')
    <h1>
        {{ $admin->trans('title.module') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        {{--<li class="active">{{ $admin->trans('title.module') }}</li>--}}
        <li class="active">{{ $admin->trans('title.module') }}</li>
    </ol>
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                <a href="{{ $admin->route('create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                    <i class="fa fa-pencil"></i> {{ $admin->trans('button.create') }}
                </a>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @include($admin->getView('partials.table'), ['lang' => $currentLocale])
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</div>
<?php if (isset($collection)): ?>
<?php foreach ($collection as $model): ?>
<!-- Modal -->
<div class="modal fade modal-danger" id="confirmation-{{ $model->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                {!! Form::open(['route' => [$admin->getRoute('destroy'), $model->id], 'method' => 'delete', 'class' => 'pull-left']) !!}
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
        <dd>{{ $admin->trans('title.create') }}</dd>
    </dl>
@stop

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= $admin->route('create') ?>" }
                ]
            });
        });
    </script>
    <script type="text/javascript">
        $(function () {
            $('.data-table').dataTable({
//                "paginate": true,
//                "lengthChange": true,
//                "filter": true,
//                "sort": true,
//                "info": true,
//                "autoWidth": true,
//                "order": [[ 0, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$currentLocale}.json") ?>'
                }
//                "columns": [
//                    null,
//                    null,
//                    null,
//                    { "sortable": false }
//                ]
            });
        });
    </script>
@stop
