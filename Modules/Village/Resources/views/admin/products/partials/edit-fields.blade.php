<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                {!! Form::label('category', trans('village::products.table.category')) !!}
                {!! Form::select('category', (new Modules\Village\Entities\ProductCategory)->getAll(),
                @$product->category->id?:Input::old('category'), ['class' => 'form-control']) !!}
                {!! $errors->first('category', '<span class="help-block">'.trans('village::products.validation.category').'</span>') !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                {!! Form::label('title', trans('village::products.table.title')) !!}
                {!! Form::text('title', Input::old('title', $product->title), ['class' => 'form-control', 'placeholder' => trans('village::products.table.title')]) !!}
                {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                {!! Form::label('price', trans('village::products.table.price')) !!}
                {!! Form::text('price', Input::old('price', $product->price), ['class' => 'form-control', 'placeholder' => trans('village::products.table.price')]) !!}
                {!! $errors->first('price', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
</div>
