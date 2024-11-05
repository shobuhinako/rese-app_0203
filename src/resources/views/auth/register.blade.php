@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
    @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif
    <div class="register__content">
        <div class="register__title">Registration</div>
        <div class="main__form">
            <form class="main__form-content" action="{{ route('register') }}" method="post">
                @csrf
                <div class="name">
                    <input class="text__box" type="text" name="name" value="{{ old('name') }}" placeholder="Username">
                </div>
                <div class="email">
                    <input class="text__box" type="email" name="email" value="{{ old('email') }}" placeholder="Email">
                </div>
                <div class="password">
                    <input class="text__box" type="password" name="password" placeholder="Password">
                </div>
                <div class="submit">
                    <input class="submit__button" type="submit" name="submit" value="登録">
                </div>
            </form>
        </div>
    </div>
@endsection