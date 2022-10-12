@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card px-4 pt-4 text-center">
            <h3>
                <strong>🚀 checklist Pro</strong>
            </h3>
            <div class="my-2">
                <p class="p-1 m-0">Do you need this information?</p> 
                <p class="p-1 m-0">checklist Pro provides search more tasks.</p>
                <h3 class="p-1 m-0">Try it Now !</h3>
            </div>
            <div class="d-flex text-center justify-content-center my-3">
                <div class="mr-4">
                    <div class="d-flex justify-content-center">
                        <img src="http://mgjansen.com/wp-content/uploads/2021/11/82921.png" width="165" height="70" alt="no-image" class="mb-2">
                    </div>
                    <form method="POST" action="{{ route('payment') }}">
                        @csrf
                        <input type="hidden" value="1" name="amount"/>
                        <button type="submit" class="btn btn-dark mb-3">Pay $1 using PayPal</button>
                    </form>
                </div>
                <div class="ml-4">
                    <div class="d-flex justify-content-center">
                        <img src="https://pay.youcan.shop/images/ycpay-logo.svg" width="125" height="70" alt="no-image" class="mb-2">
                    </div>
                    <div>
                        <a href="{{ $paymentUrl }}" class="btn btn-dark mb-3">Pay $1 using YouCanPay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection