
<hr/>

<h4 onclick="$(this).next().toggle()">
    <a href="#null">
        {{ str_replace(': '.trans('village::villages.packet.name_and_number'), ' '.trans('village::villages.packet.number'),  trans($moduleInfo['description'])) }}
    </a>
</h4>

{{-- row clodes at facilityprice view --}}
<div class="row" style="display: none" >

<div class='form-group col-xs-6 col-md-4'>
    {!! Form::label($settingName, trans($moduleInfo['description'])) !!}
    <?php if (isset($dbSettings[$settingName])): ?>
        {!! Form::text($settingName, Input::old($settingName, $dbSettings[$settingName]->plainValue), ['class' => 'form-control', 'placeholder' => trans($moduleInfo['description'])]) !!}
    <?php else: ?>
        {!! Form::text($settingName, Input::old($settingName), ['class' => 'form-control', 'placeholder' => trans($moduleInfo['description'])]) !!}
    <?php endif; ?>
</div>
