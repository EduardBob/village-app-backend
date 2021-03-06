@if($currentUser && $currentUser->hasAccess('village.serviceorderchanges.index'))
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">{{ trans('village::serviceorderchanges.widget.latest.title') }}</h3>
        </div><!-- /.box-header -->
        <div class="box-body no-padding">
            <table class="table table-striped">
                <tbody>
                <tr>
                    <th>{{ trans('village::serviceorders.table.id') }}</th>
                    <th>{{ trans('village::serviceorderchanges.table.from_status') }}</th>
                    <th>{{ trans('village::serviceorderchanges.table.to_status') }}</th>
                    <th>{{ trans('village::serviceorderchanges.table.created_at') }}</th>
                    <th>{{ trans('village::serviceorderchanges.table.user') }}</th>
                    @if($currentUser && $currentUser->inRole('admin'))
                    <th>{{ trans('village::villages.title.model') }}</th>
                    @endif
                </tr>
                @if(isset($collection))
                    <?php $statuses = array_combine(config('village.order.statuses'), trans('village::serviceorders.form.status.values')) ?>
                    @foreach($collection->load(['user', 'order', 'order.village']) as $model)
                        <tr>
                            <td>
                                @if($currentUser && $currentUser->hasAccess('village.serviceorders.edit'))
                                    <a href="{{ route('admin.village.serviceorder.edit', ['id' => $model->order->id]) }}">{{ $model->order->id }}</a>
                                @else
                                 {{ $model->order->id }}
                                @endif
                            </td>
                            <td>@if($model->from_status)<span class="label label-{{ config('village.order.label.'.$model->from_status) }}">{{ @$statuses[$model->from_status] }}</span>@endif</td>
                            <td><span class="label label-{{ config('village.order.label.'.$model->to_status) }}">{{ @$statuses[$model->to_status] }}</span></td>
                            <td>{{ $model->created_at->format(config('village.date.format')) }}</td>
                            <td>
                                @if($model->user)
                                    @if($currentUser && $currentUser->hasAccess('user.users.edit'))
                                        <a href="{{ route('admin.user.user.edit', ['id' => $model->user->id]) }}">{{ $model->user->last_name }} {{ $model->user->first_name }}</a>
                                    @else
                                     {{ $model->user->last_name }} {{ $model->user->first_name }}
                                    @endif
                                @endif
                            </td>
                            @if($currentUser && $currentUser->inRole('admin'))
                            <td>
                                @if($currentUser && $currentUser->hasAccess('village.villages.edit'))
                                    <a href="{{ route('admin.village.village.edit', ['id' => $model->order->village->id]) }}">{{ $model->order->village->name }}</a>
                                @else
                                 {{ $model->order->village->id }}
                                @endif
                            </td>
                            @endif
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div>
@endif