<?php
 if (isset($model)) $options = json_decode($model->options, true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1-1" data-toggle="tab">{{ $admin->trans('tabs.data') }}</a></li>
                <li class=""><a href="#tab_2-2" data-toggle="tab">{{ $admin->trans('tabs.answers') }}</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1-1">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                    {!! Form::label('title', $admin->trans('table.title')) !!}
                                    {!! Form::text('title', Input::old('title', @$model->title), ['class' => 'form-control', 'placeholder' => $admin->trans('table.title')]) !!}
                                    {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                                    {!! Form::label('active', $admin->trans('table.active')) !!}
                                    {!! Form::checkbox('active', (int)Input::old('active', @$model->active), (bool)Input::old('active', @$model->active), ['class' => 'flat-blue']) !!}
                                    {!! $errors->first('active', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_2-2">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group option-collection">
                                    <label>{{ $admin->trans('tabs.answers') }}</label>
                                    @if(isset($model->options))
                                        @if(is_array($options))
                                            @foreach($options as $key => $option)
                                                <div class="option form-group{{ $errors->has('options') ? ' has-error' : '' }}">
                                                    {!! Form::label('options', $admin->trans('form.answer')) !!}
                                                     <span class="option-number">№{{ $key+1 }}</span>
                                                     <div class="input-group">
                                                        {!! Form::text('options[]', Input::old('options', $option), ['class' => 'form-control']) !!}
                                                        <span class="input-group-addon remove-option btn-danger"><i class="fa fa-times"></i></span>
                                                    </div>
                                                    {!! $errors->first('options', '<span class="help-block">:message</span>') !!}
                                                </div>
                                            @endforeach
                                        @endif
                                    @endif
                                </div>

                                <div class="hidden option-template form-group">
                                    {!! Form::label('options', $admin->trans('form.answer')) !!}
                                    <span class="option-number"></span>
                                     <div class="input-group">
                                        {!! Form::text('options[]', null, ['class' => 'form-control']) !!}
                                        <span class="input-group-addon remove-option btn-danger"><i class="fa fa-times"></i></span>
                                    </div>
                                </div>

                                <button id="add-option" type="button" class="btn btn-success btn-flat pull-right">{{ $admin->trans('button.answer-create') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('village::admin.base.facility-fields')
    </div>
</div>

@section('scripts')
    @parent

    <script type="text/javascript">
    $(document).ready(function() {
        $('button#add-option').click(function(){
            $options = $('.form-group.option');
            $option = $('.option-template')
                .first()
                .clone()
                .removeClass()
                .addClass('option form-group')
            ;
            $('.option-number', $option).text('№' + ($options.length + 1));
            $('input', $option).val('');
            $('.form-group.option-collection').append($option);
        });

        $('.option-collection').on('click','.remove-option', function(){
            $(this).parents('.form-group.option').remove();
            $options = $('.form-group.option');
            $options.each(function(index){
                $('.option-number', $(this)).text('№' + (index + 1));
            });
        });
    });
    </script>
@stop