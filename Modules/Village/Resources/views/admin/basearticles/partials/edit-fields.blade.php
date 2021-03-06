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
            <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                {!! Form::label('text', $admin->trans('table.text')) !!}
                {!! Form::textarea('text', Input::old('text', @$model->text), ['class' => 'form-control ckeditor', 'placeholder' => $admin->trans('table.text')]) !!}
                {!! $errors->first('text', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                {!! Form::label('active', $admin->trans('table.active')) !!}
                {!! Form::checkbox('active', (int)Input::old('active', @$model->active), (bool)Input::old('active', @$model->active), ['class' => 'flat-blue']) !!}
                {!! $errors->first('active', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        @if(isset($model))
        <div class="col-sm-7">
            @include('media::admin.fields.file-link', [
                'entityClass' => 'Modules\\\\Village\\\\Entities\\\\BaseArticle',
                'entityId' => @$model->id,
                'zone' => 'media',
                'media' => $model->files()->first()
            ])
        </div>
        @endif
        @include('village::admin.base.facility-fields')
    </div>
</div>
