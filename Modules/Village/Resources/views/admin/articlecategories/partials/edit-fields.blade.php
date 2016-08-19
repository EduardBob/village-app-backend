<div class="box-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                {!! Form::label('title', $admin->trans('table.title')) !!}
                {!! Form::text('title', Input::old('title', @$model->title), ['class' => 'form-control', 'placeholder' => $admin->trans('table.title')]) !!}
                {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('order') ? ' has-error' : '' }}">
                {!! Form::label('order', $admin->trans('table.order')) !!}
                {!! Form::text('order', Input::old('order', @$model->order), ['class' => 'form-control', 'placeholder' => $admin->trans('table.order')]) !!}
                {!! $errors->first('order', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('is_global') ? ' has-error' : '' }}">
                {!! Form::label('is_global', $admin->trans('table.is_global')) !!}
                {!! Form::checkbox('is_global', (int)Input::old('is_global', @$model->is_global), (bool)Input::old('is_global', @$model->is_global), ['class' => 'flat-blue']) !!}
                {!! $errors->first('is_global', '<span class="help-block">:message</span>') !!}
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                {!! Form::label('active', $admin->trans('table.active')) !!}
                {!! Form::checkbox('active', (int)Input::old('active', @$model->active), (bool)Input::old('active', @$model->active), ['class' => 'flat-blue']) !!}
                {!! $errors->first('active', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        @if(isset($model))
        <div class="col-sm-12" style="display: none">
            @include('media::admin.fields.file-link', [
                'entityClass' => 'Modules\\\\Village\\\\Entities\\\\ArticleCategory',
                'entityId' => @$model->id,
                'zone' => 'media',
                'media' => $model->files()->first()
            ])
        </div>
        @endif
    </div>
</div>
