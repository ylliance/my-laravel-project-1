<?php

namespace App\Http\Controllers\Member\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Payment;
use App\Services\AlipayPlus\PaymentService;
use App\Services\AlipayPlus\Signer;
use Illuminate\Support\Facades\Config;

class AlipayHKController extends Controller
{
     private $payments;

    public function __construct(PaymentService $payments)
    {
        $this->payments = $payments;
    }

    /** Kick off a payment (POST JSON: order_id, amount_minor, currency?, terminal?) */
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|string|max:64',
            'amount_minor' => 'required|integer|min:1',
            'currency' => 'sometimes|string|size:3',
            'terminal' => 'sometimes|in:WEB,WAP,APP,web,wap,app',
        ]);

        $res = $this->payments->createCashierPayment(
            $validated['order_id'],
            (int) $validated['amount_minor'],
            strtoupper(isset($validated['currency']) ? $validated['currency'] : 'HKD'),
            strtoupper(isset($validated['terminal']) ? $validated['terminal'] : 'WEB')
        );

        if (isset($res['redirect_url'])) {
            return response()->json($res);
        }

        return response()->json(['error' => isset($res['error']) ? $res['error'] : 'UNKNOWN', 'result' => isset($res['result']) ? $res['result'] : null], 400);
    }

    /** Return page after wallet redirection. We query status and render a simple view. */
    public function return(Request $request)
    {
        $orderId = (string) $request->query('order');
        /** @var Payment|null $payment */
        $payment = Payment::where('order_id', $orderId)->latest('id')->first();
        if (!$payment) {
            abort(404);
        }
        $res = $this->payments->inquiry($payment->external_payment_id, $payment->payment_request_id);
        $status = isset($res['result']['resultStatus']) ? $res['result']['resultStatus'] : 'U';
        $code = isset($res['result']['resultCode']) ? $res['result']['resultCode'] : 'UNKNOWN';

        $payment->response_payload = $res;
        if ($status === 'S') {
            $payment->status = 'succeeded';
        } elseif ($status === 'F') {
            $payment->status = ($code === 'ORDER_IS_CLOSED') ? 'closed' : 'failed';
        } else {
            $payment->status = 'unknown';
        }
        $payment->save();

        return view('frontend.payment.alipay.result', [
            'orderId' => $orderId,
            'status' => $payment->status,
            'code' => $code,
            'amount' => $payment->amount_decimal,
            'currency' => $payment->currency,
        ]);
    }

    /** Webhook (notifyPayment). Validates signature and updates local status. */
    public function webhook(Request $request)
    {
        $config = Config::get('alipayplus');

        $clientId = $request->header('Client-Id');
        $reqTime = $request->header('Request-Time');
        $sigHeader = $request->header('Signature');

        $sigParts = Signer::parseSignatureHeader((string) $sigHeader);
        $signature = isset($sigParts['signature']) ? $sigParts['signature'] : '';

        $bodyJson = $request->getContent();
        $body = json_decode($bodyJson, true);
        if (!is_array($body)) { $body = []; }

        $signer = new Signer(
            (string) $config['client_id'],
            (string) $config['private_key'],
            (string) $config['alipay_public_key'],
            (int) $config['key_version']
        );

        $uri = '/webhooks/alipayplus/payment';
        $valid = $signature && $signer->verifySignature('POST', $uri, (string) $clientId, (string) $reqTime, $bodyJson, $signature);
        if (!$valid) {
            Log::warning('Invalid Alipay+ webhook signature');
            return response()->json(['result' => [
                'resultCode' => 'INVALID_SIGNATURE',
                'resultStatus' => 'F',
                'resultMessage' => 'signature invalid',
            ]], 400);
        }

        $paymentRequestId = isset($body['paymentRequestId']) ? $body['paymentRequestId'] : null;
        $paymentId = isset($body['paymentId']) ? $body['paymentId'] : null;
        $result = isset($body['result']) ? $body['result'] : [];
        $status = isset($result['resultStatus']) ? $result['resultStatus'] : 'U';
        $code = isset($result['resultCode']) ? $result['resultCode'] : 'UNKNOWN';

        /** @var Payment|null $payment */
        $payment = Payment::where('payment_request_id', $paymentRequestId)->first();
        if ($payment) {
            $payment->external_payment_id = $paymentId;
            $payment->last_notification = $body;
            if ($status === 'S') {
                $payment->status = 'succeeded';
            } elseif ($status === 'F') {
                $payment->status = ($code === 'ORDER_IS_CLOSED') ? 'closed' : 'failed';
            } else {
                $payment->status = 'unknown';
            }
            $payment->save();
        }

        // Respond with a signed success to Alipay+
        $respTime = gmdate('Y-m-d') . 'T' . gmdate('H:i:s') . 'Z';
        $respBody = ['result' => ['resultCode' => 'SUCCESS', 'resultStatus' => 'S', 'resultMessage' => 'success']];
        $sig = $signer->signResponse('POST', $uri, $respTime, $respBody);

        return response()->json($respBody, 200, [
            'Client-Id' => (string) $config['client_id'],
            'Response-Time' => $respTime,
            'Signature' => $sig,
        ]);
    }
}