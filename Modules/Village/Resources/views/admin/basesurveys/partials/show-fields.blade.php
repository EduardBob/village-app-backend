<?php
 $options = json_decode($model->options, true);
?>
<div class="box-body">
    <h4>Данные</h4>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('title', $admin->trans('table.title')) !!}
                <div>{{ $model->title }}</div>
            </div>
        </div>
    </div>
    @if($currentUser && $currentUser->inRole('admin'))
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('active', $admin->trans('table.active')) !!}
                <div>
                    {!! boolField($model->active) !!}
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group option-collection">
                <h4>{{ $admin->trans('tabs.answers') }}</h4>
                @if(isset($model->options))
                    @if(is_array($options))
                        @foreach($options as $key => $option)
                            <div class="option form-group{{ $errors->has('options') ? ' has-error' : '' }}">
                                 <span class="option-number">Ответ №{{ $key+1 }}</span>
                                 <div class="input-group">
                                     <div>{{ $option }}</div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
