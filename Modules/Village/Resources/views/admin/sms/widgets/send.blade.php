@if($currentUser->inRole('admin') && $currentUser->hasAccess('village.sms.send'))
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('village::sms.widget.send.title') }}</h3>

            <div class="box-tools pull-right">
                <span data-toggle="tooltip" title="Доступно только группе admin" class="badge bg-red"><i class="fa fa-question"></i></span>
                {{--<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>--}}
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
            {!! Form::open(['route' => ['admin.village.sms.send'], 'method' => 'post']) !!}
                @if($currentUser->inRole('admin'))
                    <div class="col-sm-3">
                        {!! Form::select(
                                'village_id', Input::old('id', (new Modules\Village\Entities\Village)->lists('name', 'id')),
                                Input::old('village_id', @$user->village_id),
                                ['class' => 'form-control', 'placeholder' => trans('village::sms.widget.send.village.placeholder')]
                            )
                        !!}
                    </div>
                @endif
                <div class="col-sm-9">
                    <div class="input-group">
                    {!! Form::text('text', Input::old('text'), ['class' => 'form-control', 'required' => 'required', 'maxlength' => 70, 'placeholder' => trans('village::sms.table.text')]) !!}
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Отослать</button>
                    </span>
                  </div>
                </div>
            {!! Form::close() !!}
            </div>
        </div>
        <!-- /.box-body -->
  </div>
@endif