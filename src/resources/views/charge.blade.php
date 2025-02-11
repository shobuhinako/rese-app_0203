@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/charge.css') }}">
@endsection

@section('content')
    @if(session()->has('success'))
        <div class="success__message">{{ session('success') }}</div>
    @endif

    <div class="charge__button">
        <form action="{{route('stripe.charge')}}" method="POST">
        @csrf
            <script
                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                data-key="{{ env('STRIPE_KEY') }}"
                data-amount="1000"
                data-name="お支払い画面"
                data-label="お支払い"
                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                data-locale="auto"
                data-currency="JPY">
            </script>
        </form>
    </div>

    <script src="{{ asset('js/charge.js') }}"></script>
@endsection