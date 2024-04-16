@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="top">
    <h1 class="top__content">{{ $user->name }}さん</h1>
</div>
<div class="main__content-left">
    <h2 class="main__title">予約状況</h2>
    <div class="reservation__status">
        <p class="reservation__title">予約1</p>
        <table class="reservation__content">
            <tr class="reservation__content-row">
                <th class="reservation__item-name">Shop</th>
                <tr class="reservation__item">仙人</tr>
                <th class="reservation__item-name">Date</th>
                <tr class="reservation__item">2021-04-01</tr>
                <th class="reservation__item-name">Time</th>
                <tr class="reservation__item">17:00</tr>
                <th class="reservation__item-name">Number</th>
                <tr class="reservation__item">1人</tr>
            </tr>
        </table>
    </div>
</div>
<div class="main__content-right">
    <h2 class="main__title">お気に入り店舗</h2>
</div>
@endsection
