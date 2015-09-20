<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                {!! Form::label('title', $admin->trans('table.title')) !!}
                {!! Form::text('title', Input::old('title', @$model->title), ['class' => 'form-control', 'placeholder' => $admin->trans('table.title')]) !!}
                {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                {!! Form::label('type', $admin->trans('table.type')) !!}
                {!! Form::select('type', array_combine(\Modules\Village\Entities\Margin::getTypes(), $admin->trans('form.type.values')),
                @$model->type, ['class' => 'form-control']) !!}
                {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
                {!! Form::label('value', $admin->trans('table.value')) !!}
                {!! Form::text('value', Input::old('value', @$model->value), ['class' => 'form-control', 'placeholder' => $admin->trans('table.value')]) !!}
                {!! $errors->first('value', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-1">
            <div class="form-group{{ $errors->has('order') ? ' has-error' : '' }}">
                {!! Form::label('order', $admin->trans('table.order')) !!}
                {!! Form::text('order', Input::old('order', @$model->order), ['class' => 'form-control', 'placeholder' => $admin->trans('table.order')]) !!}
                {!! $errors->first('order', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-1">
            <div class="form-group{{ $errors->has('is_removable') ? ' has-error' : '' }}">
                {!! Form::label('is_removable', $admin->trans('table.is_removable')) !!}
                <br>
                {!! Form::checkbox('is_removable', 1, Input::old('is_removable', @$model->is_removable)) !!}
                {!! $errors->first('is_removable', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
</div>
