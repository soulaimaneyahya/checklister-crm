@extends('layouts.app')

@section('content')
<div class="row justify-content-center p-0 m-0">
    <div class="col-md-12 p-0 m-0">
        <div class="card px-4 pt-4 text-center">
            <h3>
                <strong>Pay using PayPal</strong>
            </h3>
            <div class="my-2">
                <p class="p-1 m-0">🚀 checklist Pro</p>
                <p class="p-1 m-0">Do you need this information?</p> 
                <p class="p-1 m-0">checklist Pro provides search more tasks.</p>
                <h3 class="p-1 m-0">Try it Now !</h3>
            </div>
            <form method="POST" action="{{ route('payment') }}">
                @csrf
                <input type="hidden" value="1" name="amount"/>
                <button type="submit" class="btn btn-dark mb-3">Pay $1 using Paypal</button>
            </form>
        </div>
    </div>
</div>
@endsection