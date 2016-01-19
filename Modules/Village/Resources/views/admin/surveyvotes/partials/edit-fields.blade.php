<div class="box-body">
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group{{ $errors->has('survey_id') ? ' has-error' : '' }}">
                {!! Form::label('survey_id', $admin->trans('table.survey')) !!}
                {!! Form::select('survey_id', $admin->getSurveys(),
                Input::old('survey_id', @$model->survey->id), ['class' => 'form-control', 'placeholder' => $admin->trans('form.survey.placeholder')]) !!}
                {!! $errors->first('survey_id', '<span class="help-block">:message</span>') !!}
            </div>
        </div>

        <div class="col-sm-5">
            <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                {!! Form::label('user_id', $admin->trans('table.user')) !!}
                {!! Form::select('user_id', (new Modules\Village\Entities\User)->getList(),
                Input::old('user_id', @$model->user->id), ['class' => 'form-control', 'placeholder' => $admin->trans('form.user.placeholder')]) !!}
                {!! $errors->first('user_id', '<span class="help-block">:message</span>') !!}
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
