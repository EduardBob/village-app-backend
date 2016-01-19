<?php

if (!function_exists('localizeddate')) {
    function localizeddate($string, $format = 'standard')
    {
        return Jenssegers\Date\Date::parse($string)->format(config('village.date.human.'.$format));
    }
}

if (!function_exists('smsGate')) {
    /**
     * @return \Fruitware\ProstorSms\Client
     */
    function smsGate()
    {
        static $smsGate;

        if (empty($smsGate)) {
            //set basic access authentication
            $options = [
                'defaults' => [
                    'auth'    => [config('village.sms.username'), config('village.sms.password')],
                ],
            ];

            // Инициализация клиена
            $guzzleClient = new \GuzzleHttp\Client($options);
            $smsGate = $smsGate = new \Fruitware\ProstorSms\Client($guzzleClient);
        }

        return $smsGate;
    }
}

