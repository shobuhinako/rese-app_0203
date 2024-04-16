@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
    <div class="register__content">
        <div class="register__title">Registration</div>
        <div class="main__form">
            <form class="main__form-content" action="{{ route('register.post') }}" method="post">
                @csrf
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Username">
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email">
                <input type="password" name="password" placeholder="Password">
                <!-- <input type="password" name="password_confirmation" placeholder="確認用パスワード"> -->
                <input type="submit" name="submit" value="登録">
            </form>
        </div>
    </div>
@endsection