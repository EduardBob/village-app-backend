<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                {!! Form::label('title', trans('village::margins.table.title')) !!}
                {!! Form::text('title', Input::old('title', $margin->title), ['class' => 'form-control', 'placeholder' => trans('village::margins.table.title')]) !!}
                {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                {!! Form::label('type', trans('village::margins.table.type')) !!}
                {!! Form::select('type', (new Modules\Village\Entities\Margin)->getTypes(),
                (new Modules\Village\Entities\Margin)->getTypeId($margin->type), ['class' => 'form-control']) !!}
                {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
                {!! Form::label('value', trans('village::margins.table.amount')) !!}
                {!! Form::text('value', Input::old('value', $margin->value), ['class' => 'form-control', 'placeholder' => trans('village::margins.table.amount')]) !!}
                {!! $errors->first('value', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-1">
            <div class="form-group{{ $errors->has('is_removable') ? ' has-error' : '' }}">
                {!! Form::label('is_removable', trans('village::margins.table.removable')) !!}
                {!! Form::checkbox('is_removable', true, $margin->is_removable) !!}
                {!! $errors->first('is_removable', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
</div>
