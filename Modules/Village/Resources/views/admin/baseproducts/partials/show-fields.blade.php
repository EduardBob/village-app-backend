<div class="box-body">
    <h4>Данные</h4>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('category_id', $admin->trans('table.category')) !!}
                <div>{{ $model->category->title }}</div>
            </div>
        </div>
    </div>
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
                {!! Form::label('price', $admin->trans('table.price')) !!}
                <div>{{ $model->price }}</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('unit_title', $admin->trans('table.unit_title')) !!}
                <div>{{ $model->unit_title }}</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('comment_label', $admin->trans('table.comment_label')) !!}
                <div>{{ $model->comment_label }}</div>
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
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('show_perform_at', $admin->trans('table.show_perform_at')) !!}
                <div>
                    @if($model->show_perform_at)
                        <span class="label label-success">{{ trans('village::admin.table.active.yes') }}</span>
                    @else
                        <span class="label label-danger">{{ trans('village::admin.table.active.no') }}</span>
                    @endif
                </div>
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
