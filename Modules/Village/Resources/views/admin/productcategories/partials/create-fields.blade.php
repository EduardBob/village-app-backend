<div class="box-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                {!! Form::label('title', trans('village::productcategories.table.title')) !!}
                {!! Form::text('title', Input::old('title'), ['class' => 'form-control', 'placeholder' => trans('village::productcategories.table.title')]) !!}
                {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
</div>
