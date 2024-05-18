@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<!-- @if(session()->has('success_message'))
    <p>{{ session('success_message') }}</p>
@endif -->
    <div class="thanks__content">
        <div class="thanks__message">会員登録ありがとうございます</div>
        @if(session()->has('success_message'))
            <p>{{ session('success_message') }}</p>
        @endif

        <div class="resend__email-form">
            <div class="resend__email-message">本人確認メールの再送信をご希望の場合は、以下リンクをクリックしてください
            </div>
            <form class="resend__email" action="{{ route('verification.resend') }}" method="post">
            @csrf
                <button type="submit">本人確認メールの再送信</button>
            </form>
        </div>

        <div class="login__form">
            <form class="login__button" action="/login" method="get">
                @csrf
                <input type="submit" name="submit" value="ログインする">
            </form>
        </div>
    </div>
@endsection