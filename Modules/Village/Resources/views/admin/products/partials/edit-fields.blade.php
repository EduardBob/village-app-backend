<div class="box-body">
    <div class="row">
        @if (isset($model) && $model instanceof \Modules\Village\Entities\BaseProduct)
            {!! Form::hidden('base_id', Input::old('base_id', @$model->id)) !!}
        @endif

        @if($currentUser && $currentUser->inRole('admin'))
        <div class="col-sm-4">
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
        @else
            {!! Form::hidden('village_id', Input::old('village_id', @$model->village_id ? $model->village_id : $currentUser->village->id), ['id' => 'village_id']) !!}
        @endif
        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                {!! Form::label('category_id', $admin->trans('table.category')) !!}
                {!! Form::select('category_id', $admin->getCategories(),
                @$model->category->id?:Input::old('category_id'), ['class' => 'form-control', 'placeholder' => $admin->trans('form.category.placeholder')]) !!}
                {!! $errors->first('category_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        @if(isset($model))
        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('executor_id') ? ' has-error' : '' }}">
                {!! Form::label('executor_id', $admin->trans('table.executor')) !!}
                {!! Form::select('executor_id', $admin->getExecutors($model->village),
                @$model->executor->id?:Input::old('executor_id'), ['class' => 'form-control', 'placeholder' => $admin->trans('form.executor.placeholder')]) !!}
                {!! $errors->first('executor_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        @endif
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
        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('unit_title') ? ' has-error' : '' }}">
                {!! Form::label('unit_title', $admin->trans('table.unit_title')) !!}
                {!! Form::select('unit_title', array_combine(config('village.product.unit.values'), $admin->trans('form.unit_title.values')),
                Input::old('unit_title', @$model->unit_title), ['class' => 'form-control', 'placeholder' => $admin->trans('form.unit_title.placeholder')]) !!}
                {!! $errors->first('unit_title', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-8">
            <div class="form-group{{ $errors->has('comment_label') ? ' has-error' : '' }}">
                {!! Form::label('comment_label', $admin->trans('table.comment_label')) !!}
                {!! Form::text('comment_label', Input::old('comment_label', @$model->comment_label ? $model->comment_label : config('village.product.comment.label')), ['class' => 'form-control', 'placeholder' => $admin->trans('table.comment_label')]) !!}
                {!! $errors->first('comment_label', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                {!! Form::label('text', $admin->trans('table.text')) !!}
                {!! Form::textarea('text', Input::old('text', @$model->text), ['class' => 'form-control', 'placeholder' => $admin->trans('table.text'), 'maxlength' => 255]) !!}
                {!! $errors->first('text', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('show_perform_time') ? ' has-error' : '' }}">
                {!! Form::checkbox('show_perform_time', (int)Input::old('show_perform_time', @$model->show_perform_time), (bool)Input::old('show_perform_time', @$model->show_perform_time), ['class' => 'flat-blue']) !!}
                {!! Form::label('show_perform_time', $admin->trans('table.show_perform_time')) !!}
                {!! $errors->first('show_perform_time', '<span class="help-block">:message</span>') !!}
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
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('order') ? ' has-error' : '' }}">
                {!! Form::label('order', $admin->trans('table.order')) !!}
                {!! Form::text('order', Input::old('order', @$model->order), ['class' => 'form-control', 'placeholder' => $admin->trans('table.order')]) !!}
                {!! $errors->first('order', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('has_card_payment') ? ' has-error' : '' }}">
                {!! Form::checkbox('has_card_payment', (int)Input::old('has_card_payment', @$model->has_card_payment), (bool)Input::old('has_card_payment', @$model->has_card_payment), ['class' => 'flat-blue']) !!}
                {!! Form::label('has_card_payment', $admin->trans('table.has_card_payment')) !!}
                {!! $errors->first('has_card_payment', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                {!! Form::checkbox('active', (int)Input::old('active', @$model->active), (bool)Input::old('active', @$model->active), ['class' => 'flat-blue']) !!}
                {!! Form::label('active', $admin->trans('table.active')) !!}
                {!! $errors->first('active', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        @if(isset($model))
        <div class="col-sm-12">
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
