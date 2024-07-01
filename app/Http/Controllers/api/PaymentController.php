<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use PayMob\Facades\PayMob;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public static function pay(int $orderID, float $totalPrice)
    {
        $auth = PayMob::AuthenticationRequest();

        $order = PayMob::OrderRegistrationAPI([
            'auth_token' => $auth->token,
            'amount_cents' => $totalPrice * 100, //put your price
            'currency' => 'EGP',
            'delivery_needed' => true,
            'merchant_order_id' => $orderID, //put order id from your database must be unique id
            'items' => [] // all items information or leave it empty
        ]);

        $PaymentKey = PayMob::PaymentKeyRequest([
            'auth_token' => $auth->token,
            'amount_cents' => $totalPrice * 100, //put your price
            'currency' => 'EGP',
            'order_id' => $order->id,
            "billing_data" => [ // put your client information
                "email" => auth()->user()->email,
                "first_name" => auth()->user()->f_name,
                "phone_number" => auth()->user()->phone_number,
                "last_name" => auth()->user()->l_name,
            ]
        ]);

        return $PaymentKey->token;
    }

    public function checkoutProcessed(Request $request)
    {
        $request_hmac = $request->hmac;
        $calc_hmac = PayMob::calcHMAC($request);

        if ($request_hmac == $calc_hmac) {
            $order_id = $request->obj['order']['merchant_order_id'];
            $amount_cents = $request->obj['amount_cents'];
            $transaction_id = $request->obj['id'];

            $order = Order::find($order_id);

            if ($request->obj['success'] == true && ($order->total_price * 100) == $amount_cents) {
                $order->update([
                    'transaction_status' => 'finished',
                    'transaction_id' => $transaction_id
                ]);
            } else {
                $order->update([
                    'transaction_status' => "failed",
                    'transaction_id' => $transaction_id
                ]);
            }
        }
    }
}
