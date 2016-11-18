@if($currentUser && $currentUser->inRole('village-admin') && ! $village->is_unlimited)
    <div class="box box-primary packet-widget" style="padding-bottom: 20px">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('village::villages.packet.chose') }}</h3>
        </div>
        <div class="box-body">

            <div>{{ trans('village::villages.title.model') }}: <b>{!! $village->name !!}</b></div>
            <div>{{ trans('village::villages.packet.current') }}: <b>{!! $packets[$village->packet]['name'] !!}</b></div>
            <div>{{ trans('village::villages.table.payed_until') }}: <b>{!! $activeTo !!}</b></div>
            <div>{{ trans('village::villages.packet.balance') }}: <b>{{ $village->balance }}</b></div>
            <div>{{ trans('village::villages.packet.left_buildings') }}: <b>{!! $buildingsLeft !!}</b></div>
            <p></p>
            <hr/>
             <div class="row">
                @foreach($packets as $number =>$packet)
                    <div class="col-sm-4">
                        <h4>{!! $packet['name'] !!}</h4>
                        <div>{{ trans('village::villages.packet.buildings')}}: <b>{!! $packet['buildings'] !!}</b></div>
                        <div>{{ trans('village::villages.packet.coins_per_month')}}: <b>{!! $packet['price'] !!}</b> {{ trans('village::villages.packet.money')}}</div>
                        @if ($number != $village->packet && $packet['buildings'] >= $totalBuildings)
                            {!! Form::open(['route' => ['admin.village.packet.change'], 'method' => 'post']) !!}
                                <input type="hidden" name="packet" value="{{$number}}" />
                                <p></p>
                                <input type="submit" class="btn-success btn" value=" {{ trans('village::villages.packet.move_to_packet')}}"  />
                            {!! Form::close() !!}
                        @elseif($number == $village->packet)
                            <p></p>
                            <span class="btn-info btn disabled">{{ trans('village::villages.packet.current')}}</span>
                        @endif
                    </div>
                @endforeach
            </div>
            <hr/>
            <div class="row" style="text-align: center">
                <h3 class="box-title">{{ trans('village::villages.packet.add_balance_title') }}</h3>
                {!! Form::open(['route' => ['admin.village.packet.pay'], 'method' => 'post']) !!}
                <input type="hidden" name="packet" value="{{$village->packet}}"/>
                    <select name="period" id="period">
                        <option value="">{{ trans('village::villages.packet.chose_period') }}</option>
                        @for ($i = 1; $i <= 11; $i++)
                            <?php $discount = ($i >= 6) ? 25 : 0; ?>
                            <option discount="{{$discount}}"  value="{!! $i !!}">
                                {!! $i !!} {!! trans_choice('village::villages.packet.months',  $i) !!}
                                @if($discount > 0)
                                    {!! trans_choice('village::villages.packet.and_get_more',  $discount) !!}
                                @endif
                            </option>
                        @endfor
                            <option discount="50" value="12">
                                {!! trans_choice('village::villages.packet.years',  1) !!}
                                {{ trans('village::villages.packet.and_get_50_off') }}
                            </option>
                            <option discount="50" value="24">
                                {!! trans_choice('village::villages.packet.years',  2) !!}
                                {{ trans('village::villages.packet.and_get_50_off') }}
                            </option>
                            <option discount="50" value="36">
                                {!! trans_choice('village::villages.packet.years',  3) !!}
                                {{ trans('village::villages.packet.and_get_50_off') }}
                            </option>
                    </select>

                    <br/>
                    <div id="packet-info"></div>
                    <div class="btn-block" style="">
                        <input type="submit" id="packet-submit" class="btn-success btn" style="display: none" value="{{ trans('village::villages.packet.add_balance') }}">
                    </div>
                {!! Form::close() !!}
            </div>
     </div>
 </div>

    <script>
        $(document).ready(function () {
            var price = {{ $packets[$village->packet]['price']  }};
            var coefficient  = {{ setting('village::village-currency') }};
            $('#period').change(function(e){
                var $this = $(this);
                var month = $this.val();
                var discount = $this.find('[value="'+month+'"]').attr('discount');
                if( $this.val() != '')
                {
                    $('#packet-submit').show();
                    var priceInCurrency = price * (1000 / coefficient ) * month;
                    var priceCoins = price * month;
                    var discountTotal = '';
                    if(discount > 0)
                    {
                        discountTotal = ' + ' + price / 100 * discount * month + " {{ trans('village::villages.packet.bonus_coins') }}";
                    }
                    var totalHtml = '<p></p><p>{{ trans('village::villages.packet.total') }}: <b>' + priceInCurrency +'</b> {{ trans('village::villages.packet.rub') }}.</p>'
                    totalHtml += '<p>{{ trans('village::villages.packet.total_coins') }}: <b>' +priceCoins + '</b> {{ trans('village::villages.packet.money') }} <b>' + discountTotal+'</b></p>';
                    $('#packet-info').html(totalHtml);
                }
                else{
                    $('#packet-submit').hide();
                    $('#packet-info').html('');
                }
            });
        })
    </script>
@endif