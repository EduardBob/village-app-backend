<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                {!! Form::label('title', trans('village::services.table.title')) !!}
                {!! Form::text('title', Input::old('title', $service->title), ['class' => 'form-control', 'placeholder' => trans('village::services.table.title')]) !!}
                {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                {!! Form::label('category', trans('village::services.table.category')) !!}
                {!! Form::select('category', (new Modules\Village\Entities\ServiceCategory)->getAll(),
                @$service->category->id?:Input::old('category'), ['class' => 'form-control']) !!}
                {!! $errors->first('category', '<span class="help-block">'.trans('village::services.validation.title').'</span>') !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                {!! Form::label('price', trans('village::services.table.price')) !!}
                {!! Form::text('price', Input::old('price', $service->price), ['class' => 'form-control', 'placeholder' => trans('village::services.table.price')]) !!}
                {!! $errors->first('price', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
</div>
