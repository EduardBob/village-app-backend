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
        @if($currentUser && $currentUser->hasAccess($admin->getAccess('create')))
        <div class="row">
            <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                <a href="{{ $admin->route('create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                    <i class="fa fa-pencil"></i> {{  trans('core::core.button.create') }}
                </a>
            </div>
        </div>
        @endif
        <div class="box box-primary">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @section('grid')
                <style type="text/css">
                    #dataTableBuilder_wrapper {overflow-x: auto;}
                </style>

                {!! $html->table(['class' => 'table table-striped table-bordered']) !!}
                @show
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade modal-danger" id="confirm-destroy" tabindex="-1" role="dialog" aria-labelledby="confirmDestroyLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="confirmDestroyLabel">{{ trans('core::core.modal.title') }}</h4>
            </div>
            <div class="modal-body">
                {{ trans('core::core.modal.confirmation-message') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-flat" data-dismiss="modal">{{ trans('core::core.button.cancel') }}</button>
                @if($currentUser && $currentUser->hasAccess($admin->getAccess('destroy')))
                    <button type="button" class="btn btn-outline btn-flat confirm"><i class="glyphicon glyphicon-trash"></i> {{ trans('core::core.button.delete') }}</button>
                @endif
            </div>
        </div>
    </div>
</div>
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
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css">
    <script src="//cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="//cdn.datatables.net/buttons/1.1.2/js/buttons.html5.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.1.2/js/buttons.print.min.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.11/pagination/scrolling.js"></script>
    {{--<script src="//cdn.datatables.net/buttons/1.1.0/js/buttons.colVis.min.js"></script>--}}
    {{--<script src="/vendor/datatables/buttons.server-side.js"></script>--}}

    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    @if($currentUser && $currentUser->hasAccess($admin->getAccess('create')))
                        { key: 'c', route: "<?= $admin->route('create') ?>" }
                    @endif
                ]
            });
        });
    </script>

    <!-- Destroy dialog show event handler -->
    <script type="text/javascript">
        $( document ).ready(function() {
            var $modal = $('#confirm-destroy');
            $modal.on('show.bs.modal', function (e) {
                // Pass form reference to modal for submission on yes/ok
                var form = $(e.relatedTarget).closest('form');
                $(this).find('.modal-footer .confirm').data('form', form);
            });

            <!-- Form confirm (yes/ok) handler, submits form -->
            $modal.on('click', '.confirm', function(e){
                e.preventDefault();
                $(this).data('form').submit();
            });
        });
    </script>

    {!! $html->scripts() !!}
@stop
