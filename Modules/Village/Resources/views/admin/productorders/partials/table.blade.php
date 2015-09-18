<table class="data-table table table-bordered table-hover">
    <thead>
    <tr>
        <th>{{ $admin->trans('table.id') }}</th>
        <th>{{ $admin->trans('table.product') }}</th>
        <th>{{ $admin->trans('table.quantity') }}</th>
        <th>{{ $admin->trans('table.address') }}</th>
        <th>{{ $admin->trans('table.perform_at') }}</th>
        <th>{{ $admin->trans('table.price') }}</th>
        <th>{{ $admin->trans('table.name') }}</th>
        <th>{{ $admin->trans('table.phone') }}</th>
        <th>{{ $admin->trans('table.status') }}</th>
        <th>{{ trans('core::core.table.actions') }}</th>
    </tr>
    </thead>
    <tbody>
    <?php if (isset($collection)): ?>
    <?php foreach ($collection as $model): ?>
    <tr>
        <td>
            <a href="{{ $admin->route('edit', [$model->id]) }}">
                {{ $model->id }}
            </a>
        </td>
        <td>
            <a href="{{ route('admin.village.product.edit', [$model->product->id]) }}">
                {{ $model->product->title }}
            </a>
        </td>
        <td>
            {{ $model->quantity }}
        </td>
        <td>
            {{ $model->profile->building->address }}
        </td>
        <td>
            {!! Carbon\Carbon::parse($model->perform_at)->format(config('village.date.format')) !!}
        </td>
        <td>
            {{ $model->price }}
        </td>
        <td>
            @if ($model->profile)
                <a href="{{ route('admin.user.user.edit', [$model->profile->user->id]) }}">
                    {{ $model->profile->user->first_name }} {{ $model->profile->user->last_name }}
                </a>
            @endif
        </td>
        <td>
            @if ($model->profile)
                {{ $model->profile->phone }}
            @endif
        </td>
        <td>
            {{ $admin->trans('form.status.values.'.$model->status) }}
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
        <th>{{ $admin->trans('table.product') }}</th>
        <th>{{ $admin->trans('table.quantity') }}</th>
        <th>{{ $admin->trans('table.address') }}</th>
        <th>{{ $admin->trans('table.perform_at') }}</th>
        <th>{{ $admin->trans('table.price') }}</th>
        <th>{{ $admin->trans('table.name') }}</th>
        <th>{{ $admin->trans('table.phone') }}</th>
        <th>{{ $admin->trans('table.status') }}</th>
        <th>{{ trans('core::core.table.actions') }}</th>
    </tr>
    </tfoot>
</table>