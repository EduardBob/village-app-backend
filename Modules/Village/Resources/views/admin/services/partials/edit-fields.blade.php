<div class="box-body">
    <div class="row">
        @if (isset($model) && $model instanceof \Modules\Village\Entities\BaseService)
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
                {!! Form::hidden('category_id', Input::old('category_id', @$model->category_id)) !!}
                {!! Form::text('category_id_name', @$model->category->title, ['disabled' => 'disabled', 'class' => 'form-control', 'placeholder' => $admin->trans('form.category.placeholder')]) !!}
                {!! $errors->first('category_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        @if(isset($model))
        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('executor_id') ? ' has-error' : '' }}">
                {!! Form::label('executor_id', $admin->trans('table.executor')) !!}
                {!! Form::select('executors', $admin->getExecutors($model->village),
                $model->executors ? $model->executors->pluck('user_id')->all() : [], ['class' => 'form-control', 'multiple'=>'multiple', 'name'=>'executors[]']) !!}
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
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('comment_label') ? ' has-error' : '' }}">
                {!! Form::label('comment_label', $admin->trans('table.comment_label')) !!}
                {!! Form::text('comment_label', Input::old('comment_label', @$model->comment_label ? $model->comment_label : config('village.service.comment.label')), ['class' => 'form-control', 'placeholder' => $admin->trans('table.comment_label')]) !!}
                {!! $errors->first('comment_label', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('order_button_label') ? ' has-error' : '' }}">
                {!! Form::label('order_button_label', $admin->trans('table.order_button_label')) !!}
                {!! Form::text('order_button_label', Input::old('order_button_label', @$model->order_button_label ? $model->order_button_label : config('village.service.order_button.label')), ['class' => 'form-control', 'placeholder' => $admin->trans('table.order_button_label')]) !!}
                {!! $errors->first('order_button_label', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                {!! Form::label('text', $admin->trans('table.text')) !!}
                {!! Form::textarea('text', Input::old('text', @$model->text), ['class' => 'form-control', 'placeholder' => $admin->trans('table.text'), 'maxlength' => 255]) !!}
                {!! $errors->first('text', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        @if(isset($model))
        <div class="col-sm-12">
            @include('media::admin.fields.file-link', [
                'entityClass' => 'Modules\\\\Village\\\\Entities\\\\Service',
                'entityId' => @$model->id,
                'zone' => 'media',
                'media' => isset($model) ? $model->files()->first() : null
            ])
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
            <div class="form-group{{ $errors->has('show_perform_time') ? ' has-error' : '' }}">
                {!! Form::checkbox('show_perform_time', (int)Input::old('show_perform_time', @$model->show_perform_time), (bool)Input::old('show_perform_time', @$model->show_perform_time), ['class' => 'flat-blue']) !!}
                {!! Form::label('show_perform_time', $admin->trans('table.show_perform_time')) !!}
                {!! $errors->first('show_perform_time', '<span class="help-block">:message</span>') !!}
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
    </div>
</div>

@section('scripts')
    @parent

<script>
$( document ).ready(function() {
    @if($currentUser->hasAccess('village.servicecategories.getChoicesByVillage'))
    var $village = $('#village_id');
    $village.change(function(){
        var $category = $("#category_id");
        $category.html('');
        var selectedVillageId = $village.val();
        if (selectedVillageId > 0) {
            $.get('{{ URL::route('admin.village.servicecategory.get_choices_by_village', [null, null]) }}/'+selectedVillageId+'/'+'{{ @$model->category_id }}', function(data){
                $category.html(data);
            });
        }
    });

    $village.trigger('change');
    @endif
});
</script>
@stop