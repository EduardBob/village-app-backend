<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0;">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>В приложении появился новый заказ.</title>


<style type="text/css">
img {
max-width: 100%;
}
body {
-webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6;
}
body {
background-color: #f6f6f6;
}
@media only screen and (max-width: 640px) {
  h1 {
    font-weight: 600 !important; margin: 20px 0 5px !important;
  }
  h2 {
    font-weight: 600 !important; margin: 20px 0 5px !important;
  }
  h3 {
    font-weight: 600 !important; margin: 20px 0 5px !important;
  }
  h4 {
    font-weight: 600 !important; margin: 20px 0 5px !important;
  }
  h1 {
    font-size: 22px !important;
  }
  h2 {
    font-size: 18px !important;
  }
  h3 {
    font-size: 16px !important;
  }
  .container {
    width: 100% !important;
  }
  .content {
    padding: 10px !important;
  }
  .content-wrapper {
    padding: 10px !important;
  }
  .invoice {
    width: 100% !important;
  }
}
</style>
</head>

<body style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6; background: #f6f6f6; margin: 0; padding: 0;">

<table class="body-wrap" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background: #f6f6f6; margin: 0; padding: 0;">
    <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0;">
        <td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0;" valign="top"></td>
        <td class="container" width="600" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto; padding: 0;" valign="top">
            <div class="content" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background: #fff; margin: 0; padding: 0; border: 1px solid #e9e9e9;">
                    <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0;">
                        <td class="content-wrap" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0;">
                                  <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0;">
                                    <td class="content-block" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 20px; font-weight:bold; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                        В поселке {{ $data['order']->village->name }} появился новый заказ:
                                    </td>
                                </tr>
                                <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0;">
                                    <td class="content-block" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                        <strong>{{ trans('village::'.$data['type'].'orders.table.'.$data['type']) }}:</strong> {{ $data['entity']->title }}
                                    </td>
                                </tr>
                                <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0;">
                                    <td class="content-block" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                        Дата исполнения: {{ Carbon\Carbon::parse($data['order']->perform_date)->format('d-m-Y') }} {{ $data['order']->perform_time }}
                                    </td>
                                </tr>
                                @if (isset($data['order']->quantity))
                                <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0;">
                                    <td class="content-block" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                        Цена за ед.: {{ $data['order']->unit_price }}
                                    </td>
                                </tr>
                                <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0;">
                                    <td class="content-block" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                        Количество: {{ $data['order']->quantity }}
                                    </td>
                                </tr>
                                <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0;">
                                    <td class="content-block" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                        Итого: {{ $data['order']->unit_price }} x {{ $data['order']->quantity }} = {{ $data['order']->price }}
                                    </td>
                                </tr>
                                @else
                                <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0;">
                                    <td class="content-block" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                        Итого: {{ $data['order']->price }}
                                    </td>
                                </tr>
                                @endif
                                <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0;">
                                    <td class="content-block" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                        <?php $statuses = array_combine(config('village.order.payment.type.values'), trans('village::serviceorders.form.payment.type.values')) ?>
                                        Тип оплаты: {{ $statuses[$data['order']->payment_type] }}
                                    </td>
                                </tr>
                                @if ($data['order']->comment)
                                <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0;">
                                    <td class="content-block" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                        Заметка: {{ $data['order']->comment }}
                                    </td>
                                </tr>
                                @endif
                                <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0;">
                                    <td>&nbsp;</td>
                                </tr>
                                <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0;">
                                    <td class="content-block" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                        <strong>Пользователь:</strong> {{ $data['order']->user->present()->fullname() }}
                                    </td>
                                </tr>
                                <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0;">
                                    <td class="content-block" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                        Адрес: {{ @$data['order']->user->building->address }}
                                    </td>
                                </tr>
                                <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0;">
                                    <td class="content-block" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                        Телефон: {{ $data['order']->user->phone }}
                                    </td>
                                </tr>
                                @foreach ($data['executors'] as $executor)
                                <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0;">
                                    <td>&nbsp;</td>
                                </tr>

                                <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0;">
                                    <td class="content-block" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                        <strong>Исполнитель:</strong> {{ $executor->present()->fullname() }}
                                    </td>
                                </tr>
                                <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0;">
                                    <td class="content-block" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                        Телефон исполнителя: {{ $executor->phone }}
                                    </td>
                                </tr>
                                @endforeach
                                <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0;">
                                    <td>&nbsp;</td>
                                </tr>
                                <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0;">
                                    <td class="content-block" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                        Посмотреть детали можно <a href="{{ $data['adminUrl'] }}">здесь</a>.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class="footer" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
                    <table width="100%" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0;">

                    </table>
                </div></div>
        </td>
        <td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0;" valign="top"></td>
    </tr>
</table>

</body>
</html>
