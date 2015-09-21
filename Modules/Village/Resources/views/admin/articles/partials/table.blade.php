<table class="data-table table table-bordered table-hover">
    <thead>
    <tr>
        <th>{{ $admin->trans('table.title') }}</th>
        <th>{{ $admin->trans('table.active') }}</th>
        <th>{{ $admin->trans('table.created_at') }}</th>
        <th>{{ $admin->trans('table.actions') }}</th>
    </tr>
    </thead>
    <tbody>
    <?php if (isset($collection)): ?>
    <?php foreach ($collection as $model): ?>
    <tr>
        <td>
            <a href="{{ $admin->route('edit', [$model->id]) }}">
                {{ $model->title }}
            </a>
        </td>
        <td>
            @if($model->active)
                <span class="label label-success">{{ trans('village::admin.table.active.yes') }}</span>
            @else
                <span class="label label-danger">{{ trans('village::admin.table.active.no') }}</span>
            @endif
        </td>
        <td>
            {{ $model->created_at }}
        </td>
        <td>
            <div class="btn-group">
                <a href="{{ $admin->route('edit', [$model->id]) }}" class="btn btn-default btn-flat"><i class="glyphicon glyphicon-pencil"></i></a>
                <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#confirmation-{{ $model->id }}"><i class="glyphicon glyphicon-trash"></i></button>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
    <tfoot>
    <tr>
        <th>{{ $admin->trans('table.title') }}</th>
        <th>{{ $admin->trans('table.active') }}</th>
        <th>{{ $admin->trans('table.created_at') }}</th>
        <th>{{ $admin->trans('table.actions') }}</th>
    </tr>
    </tfoot>
</table>