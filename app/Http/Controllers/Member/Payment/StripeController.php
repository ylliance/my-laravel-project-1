<?php

namespace App\Http\Controllers\Member\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;


class StripeController extends Controller
{
    //
    public function showCheckout()
    {
        return view('frontend.payment.stripe.index', [
            'stripeKey' => config('services.stripe.key'),
        ]);
    }

    public function createIntent(Request $request)
    {
        $validated = $request->validate([
            // Amount in smallest currency unit (e.g., cents)
            'amount'   => 'required|integer|min:1',
            'currency' => 'required|string|size:3',
            'name'     => 'nullable|string|max:255',
            'email'    => 'nullable|email',
        ]);

        $stripe = new StripeClient(config('services.stripe.secret'));

        // Automatic payment methods = handles cards (Visa/Mastercard) + 3DS
        $intent = $stripe->paymentIntents->create([
            'amount' => $validated['amount'],
            'currency' => strtolower($validated['currency']),
            'automatic_payment_methods' => ['enabled' => true],
            'metadata' => [
                'user_email' => $validated['email'] ?? '',
            ],
        ]);

        return response()->json([
            'client_secret' => $intent->client_secret,
        ]);
    }

    public function success(Request $request)
    {
        // You can show an order receipt page here
        return view('success');
    }
}
