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
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('ends_at') ? ' has-error' : '' }}">
                                    {!! Form::label('ends_at', $admin->trans('table.ends_at')) !!}
                                    {!! Form::text('ends_at', Input::old('ends_at', Carbon\Carbon::parse(@$model->ends_at)->format('Y-m-d')), ['class' => 'js-date-field form-control']) !!}
                                    {!! $errors->first('ends_at', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-sm-7">
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
                                <div class="form-group">
                                    <label>{{ $admin->trans('tabs.answers') }}</label>
                                    @if(isset($model->options))
                                        <?php $options = json_decode($model->options, true); ?>
                                        @if(is_array($options))
                                            @foreach($options as $key => $option)
                                                <div class="form-group{{ $errors->has('options') ? ' has-error' : '' }}">
                                                    {!! Form::label('options', $admin->trans('form.answer')) !!} №{{ $key+1 }}
                                                    {!! Form::text('options[]', Input::old('options', $option), ['class' => 'form-control']) !!}
                                                    {!! $errors->first('options', '<span class="help-block">:message</span>') !!}
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="form-group{{ $errors->has('options') ? ' has-error' : '' }}">
                                                {!! Form::label('options', $admin->trans('table.option')) !!}
                                                {!! Form::text('options[]', Input::old('options'), ['class' => 'form-control']) !!}
                                                {!! $errors->first('options', '<span class="help-block">:message</span>') !!}
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
