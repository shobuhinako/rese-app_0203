@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
    <div class="thanks__content">
        <div class="thanks__message">会員登録ありがとうございます</div>
        <div class="login__form">
            <form class="login__button" action="/login" method="get">
                @csrf
                <input type="submit" name="submit" value="ログインする">
            </form>
        </div>
    </div>
@endsection