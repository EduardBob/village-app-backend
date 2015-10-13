<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                {!! Form::label('category_id', $admin->trans('table.category')) !!}
                {!! Form::select('category_id', (new Modules\Village\Entities\ProductCategory)->lists('title', 'id'),
                @$model->category->id?:Input::old('category_id'), ['class' => 'form-control', 'placeholder' => $admin->trans('form.category.placeholder')]) !!}
                {!! $errors->first('category_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                {!! Form::label('title', $admin->trans('table.title')) !!}
                {!! Form::text('title', Input::old('title', @$model->title), ['class' => 'form-control', 'placeholder' => $admin->trans('table.title')]) !!}
                {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                {!! Form::label('price', $admin->trans('table.price')) !!}
                {!! Form::text('price', Input::old('price', @$model->price), ['class' => 'form-control', 'placeholder' => $admin->trans('table.price')]) !!}
                {!! $errors->first('price', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('comment_label') ? ' has-error' : '' }}">
                {!! Form::label('comment_label', $admin->trans('table.comment_label')) !!}
                {!! Form::text('comment_label', Input::old('comment_label', @$model->comment_label ? $model->comment_label : config('village.product.comment.label')), ['class' => 'form-control', 'placeholder' => $admin->trans('table.comment_label')]) !!}
                {!! $errors->first('comment_label', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                {!! Form::label('text', $admin->trans('table.text')) !!}
                {!! Form::textarea('text', Input::old('text', @$model->text), ['class' => 'form-control', 'placeholder' => $admin->trans('table.text')]) !!}
                {!! $errors->first('text', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-7">
            <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                {!! Form::label('active', $admin->trans('table.active')) !!}
                {!! Form::checkbox('active', (int)Input::old('active', @$model->active), (bool)Input::old('active', @$model->active), ['class' => 'flat-blue']) !!}
                {!! $errors->first('active', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        @if(isset($model))
        <div class="col-sm-7">
            @include('media::admin.fields.file-link', [
                'entityClass' => 'Modules\\\\Village\\\\Entities\\\\Product',
                'entityId' => @$model->id,
                'zone' => 'media',
                'media' => isset($model) ? $model->files()->first() : null
            ])
        </div>
        @endif
    </div>
</div>
