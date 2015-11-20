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
     * @param bool   $urlEncode
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
    public function generateFormData($orderId, $amount, $returnUrl, $urlEncode = false)
    {
        $this->orderId = $orderId;
        $this->amount = (float)$amount;
        $this->returnUrl = $returnUrl;

        // Format the amount
        $amountFormatted = str_pad(number_format($this->amount, 2, '', ''), 12, '0', STR_PAD_LEFT);
        $signature = $this->generateSignature();

        // Create form fields for MPG
        $mpgData = [
            'mid'           => $this->merchantId,
            'aid'           => $this->acquirerId,
            'resp_url'      => $this->returnUrl,
            'oid'           => $this->orderId,
            'amount'        => $amountFormatted,
            'signature'     => $signature,
            'site_link'     => '',
            'merchant_mail' => config('village.order.payment.sentry.merchant_mail'),
        ];

        // Return final data
        return $mpgData;
    }

    /**
     * @param string $orderId
     * @param float  $amount
     * @param string $returnUrl
     * @param bool   $urlEncode
     *
     * @return string
     */
    public function generateRedirectUrl($orderId, $amount, $returnUrl, $urlEncode = false)
    {
        $data = $this->generateFormData($orderId, $amount, $returnUrl, $urlEncode);

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
            'ResponseCode',
            'OrderID',
            'ReasonCode',
            'ReasonCodeDesc'
        ];

        // Check is response is an array and contains the required fields
        if (is_array($response) &&
            count(array_intersect_key(array_flip($requiredFields), $response)) != count($requiredFields)) {
            throw new \Exception('Invalid response');
        }

        // Return formatted response data
        return [
            'responseCode'          => $response['ResponseCode'],
            'responseDescription'   => $this->getErrorDescription($response['ResponseCode']),
            'orderId'               => $response['OrderID'],
            'reasonDescription'     => $response['ReasonCodeDesc'],
            'reasonCode'            => $response['ReasonCode'],
            'referenceNo'           => isset($response['ReferenceNo']) ?: '',
            'authCode'              => isset($response['AuthCode']) ?: '',
            'cardNo'                => isset($response['PaddedCardNo']) ?: '',
            'signature'             => isset($response['Signature']) ?: ''
        ];
    }

    /**
     * Check if response signature matches expected
     *
     * @param string $signature     Signature to compare
     * @return boolean              Boolean true, if match, false otherwise.
     */
    public function validateSignature($signature)
    {
        return $this->generateSignature() == $signature;
    }

    /**
     * Generate signature
     *
     * @throws \Exception
     * @return string Signature string
     */
    public function generateSignature()
    {
        // Signature method can only be SHA1
        if ($this->signatureMethod != 'SHA1') {
            throw new \Exception('Unsupported signature method');
        }

        // Format the amount
        $amountFormatted = str_pad(number_format($this->amount, 2, '', ''), 12, '0', STR_PAD_LEFT);

        $signatureText = $this->password .
                         $this->merchantId .
                         $this->acquirerId .
                         $this->orderId .
                         $amountFormatted .
                         $this->purchaseCurrency;

        return base64_encode(hex2bin(sha1($signatureText)));
    }


    /**
     * Get textual error message for given code
     *
     * @param string $code
     *
     * @return string
     */
    public function getErrorDescription($code)
    {
        switch ($code) {
            case '1':
                $error = 'Transaction successful!';
                break;

            case '2':
            case '3':
            case '4':
            case '11':
                $error = 'Transaction was rejected. Please contact your bank.';
                break;

            default:
                $error = 'Something went wrong. Please try again...';
        }

        return $error;
    }

}