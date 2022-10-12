<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use Omnipay\Omnipay;


class PaymentController extends Controller
{
    private $gateway;

    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(true);
    }

    public function payment(PaymentRequest $request)
    {
        // dd($request->amount);
        try {
            $response = $this->gateway->purchase([
                'amount' => $request->amount,
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => url('success'),
                'cancelUrl' => url('error')
            ])->send();

            $response->isRedirect() ? $response->redirect() : $response->getMessage();
        
        } catch (\Throwable $th) {
            // throw $th;
            return $th->getMessage();
        }
    }


    public function success(Request $request)
    {
        $payment = Payment::where('user_id',  auth()->id())->first();
        if (!$payment) {
            if ($request->input('paymentId') && request('PayerID')) {
                $transaction = $this->gateway->completePurchase(array(
                    'payer_id' => request('PayerID'),
                    'transactionReference' => $request->input('paymentId')
                ));
                $response = $transaction->send();
                if ($response->isSuccessful()) {
                    $arr = $response->getData();
                    Payment::create([
                        'user_id' => auth()->id(),
                        'payment_id' => $arr['id'],
                        'payer_id' => $arr['payer']['payer_info']['payer_id'],
                        'payer_email' => $arr['payer']['payer_info']['email'],
                        'amount' => $arr['transactions'][0]['amount']['total'],
                        'currency' => env('PAYPAL_CURRENCY'),
                        'payment_status' => $arr['state']                        
                    ]);
                    // Your Transaction ID is ' . $arr['id']
                    return redirect()->route('welcome')->with('alert-success', 'Payment Process Success.');
                }
            }
            return redirect()->route('standalone.show')->with('alert-info', 'Payment Failed');
        } else{
            return redirect()->route('standalone.show')->with('alert-info', 'Payment Failed');
        }
    }

    public function error()
    {
        return redirect()->route('standalone.show')->with('alert-info', 'Payment Failed');
    }
}
