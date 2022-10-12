<?php

namespace App\Http\Controllers\User\Standalone;

use YouCan\Pay\YouCanPay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShowFormController extends Controller
{
    public function __construct(
        private YouCanPay $youCanPay
    )
    {
    }

    public function __invoke(Request $request)
    {
        $orderId = uniqid();

        $request->session()->put('orderId', $orderId);

        $token = $this->youCanPay->token->create(
            $orderId,
            "100",
            config('ycpay.currency'),
            $request->ip(),
            route('standalone.callback', ['success' => true]),
            route('standalone.callback', ['success' => false])
        ); //20 USD

        return view('users.checkout.index', [
            'paymentUrl' => $token->getPaymentURL()
        ]);
    }
}