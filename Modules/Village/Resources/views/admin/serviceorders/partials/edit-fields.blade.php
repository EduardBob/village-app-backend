<div class="box-body">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('service') ? ' has-error' : '' }}">
                {!! Form::label('service', trans('village::serviceorders.table.service')) !!}
                {!! Form::select('service', (new Modules\Village\Entities\Service)->getAll(),
                $serviceOrder->service->id, ['class' => 'form-control']) !!}
                {!! $errors->first('service', '<span class="help-block">'.trans('village::serviceorders.validation.service').'</span>') !!}
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('profile') ? ' has-error' : '' }}">
                {!! Form::label('profile', trans('village::serviceorders.table.profile')) !!}
                {!! Form::select('profile', (new Modules\Village\Entities\Profile)->getAll(),
                $serviceOrder->profile->user->id, ['class' => 'form-control']) !!}
                {!! $errors->first('profile', '<span class="help-block">'.trans('village::serviceorders.validation.profile').'</span>') !!}
            </div>
        </div>

        <div class="col-sm-4">
        	<div class="form-group{{ $errors->has('perform_at') ? ' has-error' : '' }}">
        	    {!! Form::label('perform_at', trans('village::serviceorders.table.perform_at')) !!}
        	    {!! Form::text('perform_at', Input::old('perform_at', 
                    Carbon\Carbon::parse($serviceOrder->perform_at)->format(config('village.dateFormat'))
                ), ['class' => 'js-date-field form-control']) !!}
        	    {!! $errors->first('perform_at', '<span class="help-block">'.trans('village::serviceorders.validation.perform_at').'</span>') !!}
        	</div>
        </div>

        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                {!! Form::label('status', trans('village::serviceorders.table.status')) !!}
                {!! Form::select('status', config('village.order.statuses'),
                (new Modules\Village\Entities\ServiceOrder)->getStatusIndex($serviceOrder->status), ['class' => 'form-control']) !!}
                {!! $errors->first('status', '<span class="help-block">'.trans('village::serviceorders.validation.status').'</span>') !!}
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group{{ $errors->has('decline_reason') ? ' has-error' : '' }}">
                {!! Form::label('decline_reason', trans('village::serviceorders.table.decline_reason')) !!}
                {!! Form::textarea('decline_reason', Input::old('decline_reason', $serviceOrder->decline_reason), ['class' => 'form-control']) !!}
                {!! $errors->first('decline_reason', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>
</div>
