<?php

namespace App\Http\Controllers\User\Standalone;

use App\Models\Payment;
use YouCan\Pay\YouCanPay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CallbackController extends Controller
{
    public function __construct(
        private YouCanPay $youCanPay
    )
    {
    }

    public function __invoke(Request $request)
    {
        if ($request->query('success')) {

            $orderId = $this->youCanPay->transaction->get($request->query('transaction_id'))?->getOrderId();

            if ($request->session()->get("orderId") === $orderId) {
                Payment::create([
                    'user_id' => auth()->id(),
                    'payment_id' => $orderId,
                    'payer_id' => $orderId,
                    'payer_email' => auth()->user()->email,
                    'amount' => "1",
                    'currency' => config('ycpay.currency'),
                    'payment_status' => "approved"
                ]);
                return redirect()->route('welcome')->with('alert-success', 'Payment Process Success.');
            }

            return redirect()->route('standalone.show')->with('alert-info', 'Payment Failed');
        }

        // return sprintf("Error: %s", $request->query('message'));
        return redirect()->route('standalone.show')->with('alert-info', $request->query('message'));
    }
}