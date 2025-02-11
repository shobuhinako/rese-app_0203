@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/send-notification.css') }}">
@endsection

@section('content')
    @if(session()->has('success'))
            <p>{{ session('success') }}</p>
    @endif
    <form action="{{ route('send-notification') }}" method="post">
    @csrf
    <div>
        <div class="item__name">宛先</div>
        <select class="select__box" name="destination">
            <option value="all">全員</option>
            <option value="user">ユーザー</option>
        </select>
    </div>

    <div>
        <div class="item__name">本文</div>
        <textarea class="message__box" name="message" cols="40" rows="10"></textarea>
    </div>
    <div class="submit__button">
        <button class="submit__button-item" type="submit">メール送信</button>
    </div>
</form>
@endsection