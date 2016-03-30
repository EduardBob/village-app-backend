<?php

namespace Modules\Village\Services;

class SentryPaymentGateway
{
    protected $debug;
    protected $gatewayUrl;
    /**
     * Логин магазина, полученный при подключении
     *
     * @var string
     */
    protected $merchantId;
    /**
     * Пароль магазина, полученный при подключении
     *
     * @var string
     */
    protected $password;
    /**
     * Адрес, на который надо перенаправить пользователя в случае успешной оплаты
     *
     * @var string
     */
    protected $returnUrl;
    /**
     * Адрес, на который надо перенаправить пользователя в случае неуспешной оплаты
     *
     * @var string
     */
    protected $failUrl;
    /**
     * Сумма платежа в копейках (или центах)
     *
     * @var int
     */
    protected $amount = 0;
    /**
     * Код валюты платежа ISO 4217. Если не указан, считается равным коду валюты по умолчанию.
     *
     * @var int
     */
    protected $currency = 643; // RUB: 643, USD: 840
	/**
	 * Адрес формы на стороне банка
	 *
	 * @var string
	 */
    protected $formUrl;

    public function __construct()
    {
        $this->debug = config('village.order.payment.sentry.debug', true);

	    if ($this->debug) {
		    $this->gatewayUrl = 'https://3dsec.sberbank.ru/payment/rest/';
		    $this->formUrl = 'https://3dsec.sberbank.ru/payment/merchants/concierge/payment_ru.html';
		    $this->merchantId = config('village.order.payment.sentry.test.mid');
		    $this->password = config('village.order.payment.sentry.test.password');
	    }
	    else {
		    $this->gatewayUrl = 'https://securepayments.sberbank.ru/payment/rest/';
		    $this->formUrl = 'https://securepayments.sberbank.ru/payment/merchants/rbs/payment_ru.html';
		    $this->merchantId = config('village.order.payment.sentry.prod.mid');
		    $this->password = config('village.order.payment.sentry.prod.password');
	    }
    }

    /**
     * @return bool
     */
    public function isDebug()
    {
        return (bool)$this->debug;
    }

    /**
     * @param string $orderId
     * @param float  $amount
     * @param string $returnUrl
     *
     * @throws \Exception
     * @return string
     */
    public function generateTransaction($orderId, $amount, $returnUrl)
    {
        $amount = (float)$amount;
        $this->returnUrl = $returnUrl;

        $data = [
            'userName'      => $this->merchantId,
            'password'      => $this->password,
            'orderNumber'   => $this->cryptOrderNumber($orderId),
            'amount'        => $this->getFormattedAmount($amount),
            'currency'      => $this->currency,
            'returnUrl'     => $returnUrl,
//            'failUrl'       => $failUrl,
            'pageView'      => 'MOBILE',
        ];

        $url = $this->gatewayUrl.'register.do?'.http_build_query($data, null, '&', PHP_QUERY_RFC3986);
        $client = new \GuzzleHttp\Client();
        $response = $client->get($url);
        /**
         * @example success response
         array (size=2)
            'orderId' => string 'b645992d-186f-4a16-a5c2-6a009c2086c0' (length=36)
            'formUrl' => string 'https://3dsec.sberbank.ru/payment/merchants/concierge/mobile_payment_ru.html?mdOrder=b645992d-186f-4a16-a5c2-6a009c2086c0&pageView=MOBILE' (length=137)
         */
        $answer = $response->json();
        if (isset($answer['orderId'])) {
            return $answer['orderId'];
        }
        else {
            throw new \Exception($answer['errorMessage'], $answer['errorCode']);
        }
    }

    /**
     * @param string $transactionId
     * @param string  $pageView DESKTOP|MOBILE
     *
     * @return string
     */
    public function generateTransactionUrl($transactionId, $pageView = 'DESKTOP')
    {
        $data = [
            'mdOrder' => $transactionId,
            'pageView' => $pageView
        ];

        return $this->formUrl.'?'.http_build_query($data, null, '&', PHP_QUERY_RFC3986);
    }

    /**
     * @param string $transactionId
     *
     * @throws \Exception
     * @return array
     */
    public function getTransactionStatus($transactionId)
    {
        $data = [
            'userName'      => $this->merchantId,
            'password'      => $this->password,
            'orderId'       => $transactionId,
        ];

        $url = $this->gatewayUrl.'getOrderStatus.do?'.http_build_query($data, null, '&', PHP_QUERY_RFC3986);
        $client = new \GuzzleHttp\Client();
        $response = $client->get($url);
        /**
         * @example success response
         * {"expiration":"201512","cardholderName":"tr tr","depositAmount":789789,"currency":"810","approvalCode":"123456","authCode":2,"clientId":"666","bindingId":"07a 90a5d-cc60-4d1b-a9e6-ffd15974a74f","ErrorCode":"0","ErrorMessage":"Успешно","OrderStatus":2,"OrderNumber":"2 3asdafaf","Pan":"411111**1111","Amount":789789}
         */
        return $response->json();
//
//        if (isset($answer['OrderStatus']) && 2 == $answer['OrderStatus']) {
//            return true;
//        }
//
//        throw new \Exception($answer['ErrorMessage'], $answer['ErrorCode']);
    }

    /**
     * @param string $orderId
     *
     * @return string
     */
    public function cryptOrderNumber($orderId)
    {
        return $this->isDebug() ? 'test_'.$orderId : $orderId;
    }

    /**
     * @param string $cryptedOrderId
     *
     * @return string
     */
    public function decryptOrderNumber($cryptedOrderId)
    {
        return str_replace('test_', '', $cryptedOrderId);
    }

    /**
     * @param float $amount
     *
     * @return int
     */
    public function getFormattedAmount($amount)
    {
        return intval($amount*100);
    }
}