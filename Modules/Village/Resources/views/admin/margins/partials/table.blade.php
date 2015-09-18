<table class="data-table table table-bordered table-hover">
    <thead>
        <tr>
            <th>{{ $admin->trans('table.title') }}</th>
            <th>{{ $admin->trans('table.type') }}</th>
            <th>{{ $admin->trans('table.value') }}</th>
            <th>{{ trans('core::core.table.actions') }}</th>
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
            {{ $admin->trans('form.type.values.'.$model->type) }}
        </td>
        <td>
            {{ $model->value }}
        </td>
        <td>
            <div class="btn-group">
                <a href="{{ $admin->route('edit', [$model->id]) }}" class="btn btn-default btn-flat"><i class="glyphicon glyphicon-pencil"></i></a>

                @if ($model->is_removable)
                    <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#confirmation-{{ $model->id }}"><i class="glyphicon glyphicon-trash"></i></button>
                @endif
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
    <tfoot>
    <tr>
        <th>{{ $admin->trans('table.title') }}</th>
        <th>{{ $admin->trans('table.value') }}</th>
        <th>{{ $admin->trans('table.type') }}</th>
        <th>{{ trans('core::core.table.actions') }}</th>
    </tr>
    </tfoot>
</table>