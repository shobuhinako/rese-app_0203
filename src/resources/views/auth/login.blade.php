@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <div class="main">
        <div class="main__title">ログイン</div>
        <div class="main__form">
            <form class="main__form-content" action="/login" method="post">
                @csrf
                <input type="email" name="email" value="" placeholder="メールアドレス">
                <input type="text" name="password" value="" placeholder="パスワード">
                <input type="submit" name="submit" value="ログイン">
            </form>
        </div>
        <div class="main__footer">
            <p class="main__footer-text">アカウントをお持ちでない方はこちらから</p>
            <a class="main__footer-link" href="{{ route('register') }}">会員登録</a>
        </div>
    </div>
@endsection