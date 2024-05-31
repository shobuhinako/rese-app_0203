@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
    <div class="done__content">
        <div class="done__message">ご予約ありがとうございます</div>

        <form class="payment" action="/charge" method="get">
        @csrf
            <input type="submit" value="お支払い">
        </form>

        <div class="back">
            <button type="submit" @if($previousUrl) onclick="location.href='{{ url($previousUrl ?? '') }}'" @else onclick="location.href='{{ url('/') }}'" @endif>戻る</button>
        </div>
    </div>
@endsection