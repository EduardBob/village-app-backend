<?php

namespace Modules\Village\Services;

/**
 * SENTRY Payment Gateway (SPG) processor.
 *
 * @link https://github.com/jawish/paymentgateway_mpg
 */
class SentryPaymentGateway
{
    public $gatewayUrl;
    public $purchaseCurrency = '643';   // RUB: 643, USD: 840
    public $purchaseCurrencyExponent = '2';
    public $acquirerId = '443222';
    public $merchantId;
    public $password;
    public $version = '1.0.0';
    public $signatureMethod = 'SHA1';
    public $returnUrl;
    public $orderId = 0;
    public $amount = 0;

    public function __construct()
    {
        // debug
        if (config('village.order.payment.sentry.debug')) {
            $this->gatewayUrl = 'https://mpi.mkb.ru:9443/MPI_payment/';
            $this->merchantId = config('village.order.payment.sentry.test.mid');
            $this->password = config('village.order.payment.sentry.test.password');
        }
        // prod
        else {
            $this->gatewayUrl = 'https://mpi.mkb.ru:8443/MPI_payment/';
            $this->merchantId = config('village.order.payment.sentry.prod.mid');
            $this->password = config('village.order.payment.sentry.prod.password');
        }
    }

    /**
     * Generate the form data and return as array
     *
     * @param string $orderId
     * @param float  $amount
     * @param string $returnUrl
     *
     * @return array            Array form data to be POST'ed to MPG.
     *                          Attributes:
     *                          - Version
     *                          - MerID
     *                          - AcqID
     *                          - MerRespURL
     *                          - PurchaseCurrency
     *                          - PurchaseCurrencyExponent
     *                          - OrderID
     *                          - SignatureMethod
     *                          - PurchaseAmt
     *                          - Url
     *                          - Signature
     */
    public function generateFormData($orderId, $amount, $returnUrl)
    {
        $amount = (float)$amount;
        $this->returnUrl = $returnUrl;

        // Create form fields for MPG
        $mpgData = [
            'mid'           => $this->merchantId,
            'aid'           => $this->acquirerId,
            'resp_url'      => $this->returnUrl,
            'oid'           => $orderId,
            'amount'        => $this->getFormattedAmount($amount),
            'signature'     => $this->generateSignature($orderId, $amount),
            'site_link'     => route('homepage'),
            'merchant_mail' => config('village.order.payment.sentry.merchant_mail'),
        ];

        // Return final data
        return $mpgData;
    }

    /**
     * @param string $orderId
     * @param float  $amount
     * @param string $returnUrl
     *
     * @return string
     */
    public function generateRedirectUrl($orderId, $amount, $returnUrl)
    {
        $data = $this->generateFormData($orderId, $amount, $returnUrl);

        return $this->gatewayUrl.'?'.http_build_query($data, null, '&', PHP_QUERY_RFC3986);
    }

    /**
     * Process response
     *
     * @param $response array Response from server, usually the $_POST variable.
     *
     * @throws \Exception
     * @return array          Parsed response
     */
    public function processResponse(array $response)
    {
        $requiredFields = [
            'Signature',
            'ResponseCode',
            'OrderID',
            'ReasonCode',
            'ReasonCodeDesc'
        ];

        // Check is response is an array and contains the required fields
        if (is_array($response) && count(array_intersect_key(array_flip($requiredFields), $response)) != count($requiredFields)) {
            throw new \Exception('Invalid response data: '.json_encode($response));
        }

        // Если что-то не так, то ничего не делаем
        if (1 != $response['ResponseCode']) {
            throw new \Exception('Invalid ResponseCode');
        }

        if (!$this->validateResponseSignature($response)) {
            throw new \Exception('Signature validation failure');
        }

        return $response;
    }

    /**
     * Check if response signature matches expected
     *
     * @param array $response
     *
     * @throws \Exception
     * @return array Boolean true, if match, false otherwise.
     */
    public function validateResponseSignature(array $response)
    {
        // Signature method can only be SHA1
        if ($this->signatureMethod != 'SHA1') {
            throw new \Exception('Unsupported signature method');
        }

        $signatureText = $this->password .
                         $this->merchantId .
                         $this->acquirerId .
                         $response['OrderID'] .
                         $response['ResponseCode'] .
                         $response['ReasonCode']
        ;

        return base64_encode(hex2bin(sha1($signatureText))) === $response['Signature'];
    }

    /**
     * Generate signature
     *
     * @param string $orderId
     * @param float  $amount
     *
     * @throws \Exception
     * @return string Signature string
     */
    public function generateSignature($orderId, $amount)
    {
        // Signature method can only be SHA1
        if ($this->signatureMethod != 'SHA1') {
            throw new \Exception('Unsupported signature method');
        }

        $signatureText = $this->password .
                         $this->merchantId .
                         $this->acquirerId .
                         $orderId .
                         $this->getFormattedAmount($amount) .
                         $this->purchaseCurrency;

        return base64_encode(hex2bin(sha1($signatureText)));
    }

    public function getFormattedAmount($amount)
    {
        return str_pad(number_format($amount, 2, '', ''), 12, '0', STR_PAD_LEFT);
    }
}