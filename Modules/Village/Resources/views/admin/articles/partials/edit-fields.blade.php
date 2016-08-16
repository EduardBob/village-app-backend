<div class="box-body">
    @if (isset($model) && $model instanceof \Modules\Village\Entities\BaseArticle)
        {!! Form::hidden('base_id', Input::old('base_id', @$model->id)) !!}
    @endif

    <div class="row">
        @if($currentUser && $currentUser->inRole('admin'))
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('village_id') ? ' has-error has-feedback' : '' }}">
                {!! Form::label('village_id', trans('village::villages.form.village_id')) !!}
                {!! Form::select(
                        'village_id', Input::old('id', (new Modules\Village\Entities\Village)->lists('name', 'id')),
                        Input::old('village_id', @$model->village_id),
                        ['class' => 'form-control', 'placeholder' => trans('village::villages.form.village.placeholder')]
                    )
                !!}
                {!! $errors->first('village_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        @endif
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                {!! Form::label('category_id', $admin->trans('table.category')) !!}
                {!! Form::select('category_id', $admin->getCategories(),
                @$model->category->id?:Input::old('category_id'), ['class' => 'form-control'], '') !!}
                {!! $errors->first('category_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('published_at') ? ' has-error' : '' }}">
                {!! Form::label('published_at', $admin->trans('table.published_at')) !!}
                {!! Form::datetime('published_at',
                   @$model->published_at?:date('Y-m-d H:i:s')
                 , ['class' => 'form-control', 'placeholder' => $admin->trans('table.published_at')]) !!}
                {!! $errors->first('published_at', '<span class="help-block">:message</span>') !!}
            </div>
        </div>

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
                {!! Form::textarea('text', Input::old('text', @$model->text), ['class' => 'form-control  ckeditor', 'placeholder' => $admin->trans('table.text')]) !!}
                {!! $errors->first('text', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                {!! Form::checkbox('active', (int)Input::old('active', @$model->active), (bool)Input::old('active', @$model->active), ['class' => 'flat-blue']) !!}
                {!! Form::label('active', $admin->trans('table.active')) !!}
                {!! $errors->first('active', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        @if (!isset($model))
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('show_all') ? ' has-error' : '' }}">
                {!! Form::checkbox('show_all', (int)Input::old('show_all', 0), (bool)Input::old('show_all', 0), ['class' => 'flat-blue']) !!}
                {!! Form::label('show_all', $admin->trans('table.show_all')) !!}
                {!! $errors->first('show_all', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        @endif
        @if(isset($model))
        <div class="col-sm-7">
            @include('media::admin.fields.file-link', [
                'entityClass' => 'Modules\\\\Village\\\\Entities\\\\Article',
                'entityId' => @$model->id,
                'zone' => 'media',
                'media' => $model->files()->first()
            ])
        </div>
        @endif
    </div>
</div>
