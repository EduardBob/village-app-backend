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
                        @if (isset($model) && $model instanceof \Modules\Village\Entities\BaseSurvey)
                            {!! Form::hidden('base_id', Input::old('base_id', @$model->id)) !!}
                        @endif

                        <div class="row">
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
                            @endif
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                    {!! Form::label('title', $admin->trans('table.title')) !!}
                                    {!! Form::text('title', Input::old('title', @$model->title), ['class' => 'form-control', 'placeholder' => $admin->trans('table.title')]) !!}
                                    {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('ends_at') ? ' has-error' : '' }}">
                                    {!! Form::label('ends_at', $admin->trans('table.ends_at')) !!}
                                    {!! Form::text('ends_at', Input::old('ends_at', Carbon\Carbon::parse(@$model->ends_at)->format('Y-m-d')), ['class' => 'js-date-field form-control']) !!}
                                    {!! $errors->first('ends_at', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                                    {!! Form::checkbox('active', (int)Input::old('active', @$model->active), (bool)Input::old('active', @$model->active), ['class' => 'flat-blue']) !!}
                                    {!! Form::label('active', $admin->trans('table.active')) !!}
                                    {!! $errors->first('active', '<span class="help-block">:message</span>') !!}
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
                        </div>
                        @if(isset($model) && isset($votesCount))
                        <div class="row">
                            <div class="box box-default">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Отданные голоса: всего ({{ $totalVotes }})</h3>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer no-padding">
                                    <ul class="nav nav-pills nav-stacked">
                                        @if(isset($model->options))
                                            @if(is_array($options))
                                                @foreach($options as $key => $option)
                                                    <li>
                                                        <a href="#">{{ $option }}
                                                            <span class="pull-right">
                                                                @if(isset($votesCount[$key])){{ $votesCount[$key] }}@else 0 @endif
                                                            </span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <!-- /.box -->
                        </div>
                        @endif
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