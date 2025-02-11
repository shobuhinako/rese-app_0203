@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin-mypage.css') }}">
@endsection

@section('content')
<div class="top">
    <h1 class="top__content">{{ $user->name }}さん</h1>
</div>

<div class="create__users">
    <div class="create__admin-users">
        <form class="create__form" action="{{ route('show.admin') }}" method="get">
        @csrf
            <input type="submit" value="管理者作成">
        </form>
    </div>

    <div class="create__store-managers">
        <form class="create__form" action="{{ route('show.manager') }}" method="get">
        @csrf
            <input type="submit" value="店舗代表者作成">
        </form>
    </div>

    <div class="send__notification">
        <form class="notification__form-show" action="{{route('send.notification.show') }}" method="get">
        @csrf
            <input type="submit" value="お知らせメール作成">
        </form>
    </div>
@endsection