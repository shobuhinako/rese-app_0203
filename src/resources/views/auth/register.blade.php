@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
    <div class="register__content">
        <div class="register__title">会員登録</div>
        <div class="main__form">
            <form class="main__form-content" action="/register" method="post">
                @csrf
                <input type="text" name="name" value="{{ old('name') }}" placeholder="名前">
                <input type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレス">
                <input type="password" name="password" placeholder="パスワード">
                <input type="password" name="password_confirmation" placeholder="確認用パスワード">
                <input type="submit" name="submit" value="会員登録">
            </form>
        </div>
    </div>
    <div class="main__footer">
        <p class="main__footer-text">アカウントをお持ちの方はこちらから</p>
        <a class="main__footer-link" href="{{ route('login') }}">ログイン</a>
    </div>
@endsection