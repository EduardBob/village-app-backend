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
                <div>{!! $model->text !!}</div>
            </div>
        </div>
    </div>
    @if($currentUser && $currentUser->inRole('admin'))
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('active', $admin->trans('table.active')) !!}
                <div>
                    {!! boolField($model->active) !!}
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
