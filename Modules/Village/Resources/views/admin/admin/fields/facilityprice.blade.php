<div class='form-group col-xs-6 col-md-4'>
    {!! Form::label($settingName, trans($moduleInfo['description'])) !!}
    <?php if (isset($dbSettings[$settingName])): ?>
        {!! Form::text($settingName, Input::old($settingName, $dbSettings[$settingName]->plainValue), ['class' => 'form-control', 'placeholder' => trans($moduleInfo['description'])]) !!}
    <?php else: ?>
        {!! Form::text($settingName, Input::old($settingName), ['class' => 'form-control', 'placeholder' => trans($moduleInfo['description'])]) !!}
    <?php endif; ?>
</div>
<div class="clearfix"></div>

</div>
{{-- row opened at facilityname view --}}