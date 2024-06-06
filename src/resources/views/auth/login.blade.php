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
                <input type="email" name="email" value="" placeholder="Email">
                <input type="text" name="password" value="" placeholder="Password">
                <input type="submit" name="submit" value="ログイン">
            </form>
        </div>
    </div>
@endsection