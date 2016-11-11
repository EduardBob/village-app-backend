@if($currentUser && $currentUser->inRole('village-admin') && ! $village->is_unlimited)
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('village::villages.packet.chose') }}</h3>
        </div>
        <div class="box-body">
            <br/>
            {{ trans('village::villages.title.model') }}: {!! $village->name !!},<br/>
            {{ trans('village::villages.packet.current') }}: {!! $packets[$village->packet]['name']  !!}<br/>
            {{ trans('village::villages.table.payed_until') }}: {!! $activeTo !!}<br/>
            {{ trans('village::villages.packet.balance') }}: {!! $village->balance !!}   {{ trans('village::villages.packet.money') }}<br/>
            {{ trans('village::villages.packet.left_buildings') }}: {!! $buildingsLeft !!}
            <div class="row">
                @foreach($packets as $number =>$packet)
                    <div class="col-sm-4">
                        <h4>{!! $packet['name'] !!}</h4>
                        {{ trans('village::villages.packet.buildings')}}: {!! $packet['buildings'] !!}<br/>
                        {!! $packet['price'] !!} {{ trans('village::villages.packet.coins_per_month')}}<br/>
                        @if ($number != $village->packet && $packet['buildings'] > $buildingsLeft)
                            {!! Form::open(['route' => ['admin.village.packet.change'], 'method' => 'post']) !!}
                                <input type="hidden" name="packet" value="{{$number}}" />
                                <input type="submit" class="btn-success" value=" {{ trans('village::villages.packet.move_to_packet')}}"  />
                            {!! Form::close() !!}
                        @elseif($number == $village->packet)
                            <span class="btn-info">{{ trans('village::villages.packet.current')}}</span>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="row" style="text-align: center">
                <h3 class="box-title">{{ trans('village::villages.packet.add_balance_title') }}</h3>
                {!! Form::open(['route' => ['admin.village.packet.pay'], 'method' => 'post']) !!}
                    <select name="name">
                        <option value="1">1 месяц</option>
                        <option value="2">2 месяц</option>
                        <option value="3">3 месяц</option>
                    </select>
                    <br/>
                    <input type="submit" class="btn-success" value="{{ trans('village::villages.packet.add_balance') }}">
                {!! Form::close() !!}
            </div>
     </div>
 </div>
@endif