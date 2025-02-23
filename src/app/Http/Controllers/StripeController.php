<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class StripeController extends Controller
{
    public function charge(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));//シークレットキー

        $charge = Charge::create(array(
            'amount' => 1000,
            'currency' => 'jpy',
            'source'=> request()->stripeToken,
        ));
        return back()->with('success', 'お支払いが完了しました');;
    }

    public function showCharge(){
        return view('charge');
    }
}
