<div class="box-body">
    <h4>Данные</h4>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('title', $admin->trans('table.title')) !!}
                <div>{{ $model->title }}</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('text', $admin->trans('table.text')) !!}
                <div>{{ $model->text }}</div>
            </div>
        </div>
    </div>
    @if($currentUser && $currentUser->inRole('admin'))
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('active', $admin->trans('table.active')) !!}
                <div>
                    @if($model->active)
                        <span class="label label-success">{{ trans('village::admin.table.active.yes') }}</span>
                    @else
                        <span class="label label-danger">{{ trans('village::admin.table.active.no') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
