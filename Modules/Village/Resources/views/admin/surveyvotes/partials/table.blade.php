<table class="data-table table table-bordered table-hover">
    <thead>
    <tr>
        <th>{{ $admin->trans('table.survey') }}</th>
        <th>{{ $admin->trans('table.profile') }}</th>
        <th>{{ $admin->trans('table.choice') }}</th>
        <th>{{ trans('core::core.table.actions') }}</th>
    </tr>
    </thead>
    <tbody>
    <?php if (isset($collection)): ?>
    <?php foreach ($collection as $model): ?>
    <tr>
        <td>
            @if ($model->survey)
                <a href="{{ route('admin.village.survey.edit', [$model->survey->id]) }}">
                    {{ $model->survey->title }}
                </a>
            @endif
        </td>
        <td>
            @if ($model->profile)
                <a href="{{ route('admin.user.user.edit', [$model->profile->user->id]) }}">
                    {{ $model->profile->user->first_name }} {{ $model->profile->user->last_name }}
                </a>
            @endif
        </td>
        <td>
            {{ $model->choice }}
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
        <th>{{ $admin->trans('table.survey') }}</th>
        <th>{{ $admin->trans('table.profile') }}</th>
        <th>{{ $admin->trans('table.choice') }}</th>
        <th>{{ trans('core::core.table.actions') }}</th>
    </tr>
    </tfoot>
</table>