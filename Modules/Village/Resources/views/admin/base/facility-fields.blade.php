<?php $types =  \Modules\Village\Entities\Village::getTypes(); ?>

<div class="col-sm-12">
    <h4>{{ trans('village::villages.services.create_in')  }}</h4>
    @foreach ($types as $type)
        <?php $typeProperty = 'is_'.$type; ?>
        <div class="form-group{{ $errors->has($typeProperty) ? ' has-error' : '' }}">
            <div class="form-group{{ $errors->has($typeProperty) ? ' has-error' : '' }}">
                {!! Form::checkbox($typeProperty, (int)Input::old('active', @$model->$typeProperty), (bool)Input::old($typeProperty, @$model->$typeProperty), ['class' => 'flat-blue']) !!}
                {!! Form::label($typeProperty,  trans('village::villages.type.' . $type)) !!}
                {!! $errors->first($typeProperty, '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    @endforeach
</div>