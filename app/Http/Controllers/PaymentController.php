<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Stripe\Stripe;
use Stripe\Charge;

class PaymentController extends Controller
{
    public function charge(Request $request)
    {
        // Determine the correct Stripe secret key based on the environment
        $stripeKey = config('services.stripe.env') === 'production'
            ? config('services.stripe.live_secret')
            : config('services.stripe.test_secret');

        // Set the Stripe secret key
        Stripe::setApiKey($stripeKey);

        // Create the charge
        $charge = Charge::create([
            'amount' => $request->amount * 100, // amount in cents
            'currency' => 'usd',
            'source' => $request->stripeToken,
            'description' => 'Payment Description',
        ]);

        // Return a success response
        return response()->json(['success' => 'Payment Successful']);
    }
}
