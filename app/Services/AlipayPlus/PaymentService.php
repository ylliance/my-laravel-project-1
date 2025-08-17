<?php

namespace App\Services\AlipayPlus;

use App\Payment;
use Client;
use Illuminate\Support\Str;

class PaymentService
{
    /** @var Client */
    private $client;
    /** @var array */
    private $config;

    public function __construct(Client $client, array $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    /** Create Cashier Payment and return redirect URL or app paymentData. */
    public function createCashierPayment(string $orderId, int $amountMinor, string $currency = 'HKD', string $terminal = 'WEB'): array
    {
        $payment = Payment::create([
            'payment_request_id' => (string) Str::uuid(),
            'external_payment_id' => null,
            'order_id' => $orderId,
            'amount_minor' => $amountMinor,
            'currency' => $currency,
            'status' => 'processing',
        ]);

        $endpoint = '/aps/api/v1/payments/pay';

        $redirectUrl = rtrim((string) $this->config['payment_redirect_base'], '/') . '/alipayhk/return?order=' . urlencode($orderId);
        $notifyUrl = (string) $this->config['payment_notify_url'];

        $body = [
            'paymentRequestId' => $payment->payment_request_id,
            'order' => [
                'orderId' => $orderId,
                'orderDescription' => 'Order #' . $orderId,
                'orderAmount' => [
                    'value' => (string) $this->toDecimal($amountMinor),
                    'currency' => $currency,
                ],
                'env' => [
                    'terminalType' => strtoupper($terminal),
                ],
            ],
            'paymentAmount' => [
                'value' => (string) $this->toDecimal($amountMinor),
                'currency' => $currency,
            ],
            'paymentFactor' => [
                'isInStorePayment' => 'false',
                'isCashierPayment' => 'true',
                'presentmentMode' => 'UNIFIED',
            ],
            'paymentMethod' => [
                'paymentMethodType' => 'CONNECT_WALLET',
            ],
            'paymentNotifyUrl' => $notifyUrl,
            'paymentRedirectUrl' => $redirectUrl,
        ];

        if (!empty($this->config['settlement_currency'])) {
            $body['settlementStrategy'] = [
                'settlementCurrency' => $this->config['settlement_currency'],
            ];
        }
        if (!empty($this->config['user_region'])) {
            $body['userRegion'] = $this->config['user_region'];
        }

        $res = $this->client->post($endpoint, $this->stringifyScalars($body));
        $payment->response_payload = $res;

        $resultStatus = isset($res['result']['resultStatus']) ? $res['result']['resultStatus'] : 'U';
        $resultCode = isset($res['result']['resultCode']) ? $res['result']['resultCode'] : 'UNKNOWN';

        if ($resultStatus === 'U' && $resultCode === 'PAYMENT_IN_PROCESS') {
            $payment->external_payment_id = isset($res['paymentId']) ? $res['paymentId'] : null;
            $payment->status = 'processing';
            $payment->save();

            return [
                'payment_id' => $payment->external_payment_id,
                'payment_request_id' => $payment->payment_request_id,
                'redirect_url' => isset($res['normalUrl']) ? $res['normalUrl'] : null,
                'payment_data' => isset($res['paymentData']) ? $res['paymentData'] : null,
            ];
        }

        if ($resultStatus === 'S') {
            $payment->status = 'succeeded';
        } elseif ($resultStatus === 'F') {
            $payment->status = 'failed';
        } else {
            $payment->status = 'unknown';
        }
        $payment->save();

        return [
            'error' => $resultCode,
            'result' => isset($res['result']) ? $res['result'] : null,
        ];
    }

    /** Query payment if webhook not yet received or for return page. */
    public function inquiry(string $paymentId = null, string $paymentRequestId = null): array
    {
        $endpoint = '/aps/api/v1/payments/inquiryPayment';
        $body = [];
        if ($paymentId !== null) { $body['paymentId'] = $paymentId; }
        if ($paymentRequestId !== null) { $body['paymentRequestId'] = $paymentRequestId; }
        return $this->client->post($endpoint, $this->stringifyScalars($body));
    }

    private function toDecimal(int $minor): string
    {
        return number_format($minor / 100, 2, '.', '');
    }

    private function stringifyScalars(array $input): array
    {
        $out = [];
        foreach ($input as $k => $v) {
            if (is_array($v)) {
                $out[$k] = $this->stringifyScalars($v);
            } elseif (is_bool($v)) {
                $out[$k] = $v ? 'true' : 'false';
            } elseif (is_int($v) || is_float($v)) {
                $out[$k] = (string) $v;
            } else {
                $out[$k] = $v;
            }
        }
        return $out;
    }
}