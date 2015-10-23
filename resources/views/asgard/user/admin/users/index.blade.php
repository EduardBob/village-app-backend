@extends('layouts.master')

@section('content-header')
<h1>
    {{ trans('user::users.title.users') }}
</h1>
<ol class="breadcrumb">
    <li><a href="{{ URL::route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li class="active">{{ trans('user::users.breadcrumb.users') }}</li>
</ol>
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">
        @if($currentUser->hasAccess('user.users.create'))
        <div class="row">
            <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                <a href="{{ URL::route('admin.user.user.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                    <i class="fa fa-pencil"></i> {{ trans('user::users.button.new-user') }}
                </a>
            </div>
        </div>
        @endif
        <div class="box box-primary">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="data-table table table-bordered table-hover">
                    <thead>
                        @section('table-head')
                        <tr>
                            @if($currentUser->hasAccess(['village.villages.edit']))
                                <th>{{ trans('village::villages.title.model') }}</th>
                            @endif
                            <th>{{ trans('user::users.table.first-name') }}</th>
                            <th>{{ trans('user::users.table.last-name') }}</th>
                            <th>{{ trans('village::users.table.phone') }}</th>
                            <th>{{ trans('village::buildings.table.address') }}</th>
                            <th>{{ trans('user::users.table.actions') }}</th>
                        </tr>
                        @show
                    </thead>
                    <tbody>
                    <?php if (isset($users)): ?>
                        <?php $users = $users->load(['village', 'building']); ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                @if($currentUser->hasAccess(['village.villages.edit']))
                                <td>
                                    <a href="{{ URL::route('admin.village.village.edit', [$user->village->id]) }}">
                                        {{ $user->village->name }}
                                    </a>
                                </td>
                                @endif
                                <td>
                                    <a href="{{ URL::route('admin.user.user.edit', [$user->id]) }}">
                                        {{ $user->first_name }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ URL::route('admin.user.user.edit', [$user->id]) }}">
                                        {{ $user->last_name }}
                                    </a>
                                </td>
                                <td>
                                    @if ($user->phone)
                                        <a href="{{ URL::route('admin.user.user.edit', [$user->id]) }}">
                                            {{ $user->phone }}
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->building)
                                        {{ $user->building->address }}
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        @if($currentUser->hasAccess('user.users.edit'))
                                            <a href="{{ URL::route('admin.user.user.edit', [$user->id]) }}" class="btn btn-default btn-flat"><i class="glyphicon glyphicon-pencil"></i></a>
                                        @endif
                                        @if($user->id != $currentUser->id && $currentUser->hasAccess('user.users.destroy'))
                                            <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#confirmation-{{ $user->id }}"><i class="glyphicon glyphicon-trash"></i></button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                    <tfoot>
                        @yield('table-head')
                    </tfoot>
                </table>
            <!-- /.box-body -->
            </div>
        <!-- /.box -->
    </div>
<!-- /.col (MAIN) -->
</div>
</div>

<?php if (isset($users)): ?>
    <?php foreach ($users as $user): ?>
    <!-- Modal -->
    <div class="modal fade modal-danger" id="confirmation-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                    {!! Form::open(['route' => ['admin.user.user.destroy', $user->id], 'method' => 'delete', 'class' => 'pull-left']) !!}
                        <button type="submit" class="btn btn-outline btn-flat"><i class="glyphicon glyphicon-trash"></i> {{ trans('core::core.button.delete') }}</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>
@stop

@section('scripts')
<?php $locale = App::getLocale(); ?>
<script type="text/javascript">
    $( document ).ready(function() {
        $(document).keypressAction({
            actions: [
                { key: 'c', route: "<?= route('admin.user.user.create') ?>" }
            ]
        });
    });
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
            }
//            ,"columns": [
//                null,
//                null,
//                null,
//                null,
//                { "sortable": false }
//            ]
        });
    });
</script>
@stop
