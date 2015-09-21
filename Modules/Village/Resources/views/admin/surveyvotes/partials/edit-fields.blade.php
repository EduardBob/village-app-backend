<div class="box-body">
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group{{ $errors->has('survey') ? ' has-error' : '' }}">
                {!! Form::label('survey', $admin->trans('table.survey')) !!}
                {!! Form::select('survey', (new Modules\Village\Entities\Survey)->lists('title', 'id'),
                Input::old('survey', @$model->survey->id), ['class' => 'form-control', 'placeholder' => $admin->trans('form.survey.placeholder')]) !!}
                {!! $errors->first('survey', '<span class="help-block">:message</span>') !!}
            </div>
        </div>

        <div class="col-sm-5">
            <div class="form-group{{ $errors->has('user') ? ' has-error' : '' }}">
                {!! Form::label('user', $admin->trans('table.user')) !!}
                {!! Form::select('user', (new Modules\Village\Entities\User)->getList(),
                Input::old('user', @$model->user->id), ['class' => 'form-control', 'placeholder' => $admin->trans('form.user.placeholder')]) !!}
                {!! $errors->first('user', '<span class="help-block">:message</span>') !!}
            </div>
        </div>

        <div class="col-sm-2">
        	<div class="form-group{{ $errors->has('choice') ? ' has-error' : '' }}">
        	    {!! Form::label('choice', $admin->trans('table.choice')) !!}
        	    {!! Form::text('choice', Input::old('choice', @$model->choice), ['class' => 'form-control']) !!}
        	    {!! $errors->first('choice', '<span class="help-block">:message</span>') !!}
        	</div>
        </div>
    </div>
</div>
