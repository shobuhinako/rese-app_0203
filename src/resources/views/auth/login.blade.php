@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')

    @if(session('message'))
        <div class="alert alert-warning">
            {{ session('message') }}
        </div>
    @endif
    @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif
    <div class="main">
        <div class="main__title">Login</div>
        <div class="main__form">
            <form class="main__form-content" action="/login" method="post">
                @csrf
                <div class="email">
                    <input class="text__box" type="email" name="email" value="" placeholder="Email">
                </div>
                <div class="password">
                    <input class="text__box" type="text" name="password" value="" placeholder="Password">
                </div>
                <div class="submit">
                    <input class="submit__button" type="submit" name="submit" value="ログイン">
                </div>
            </form>
        </div>
    </div>
@endsection