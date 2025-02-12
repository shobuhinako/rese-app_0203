@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/manager-mypage.css') }}">
@endsection

@section('content')
<div class="top">
    <h1 class="top__content">{{ $user->name }}さん</h1>
</div>

<div class="manage__shop">
    <div class="update__shop-information">
        <form class="create__form" action="{{ route('shop.update.show') }}" method="get">
        @csrf
            <input type="submit" value="店舗情報更新">
        </form>
    </div>

    <div class="create__shop">
        <form class="upload__form" action="{{ route('show.import.form') }}" method="get">
        @csrf
            <input type="submit" value="店舗作成、画像アップロード">
        </form>
    </div>

    <div class="reservation__status">
        <p class="reservation__status-title">
            予約状況
        </p>
        @foreach ($reservations as $reservation)
        <table class="reservation__content">
            <tr class="reservation__content-row">
                <th class="item__name">Name</th>
                <th class="item__name">Shop</th>
                <th class="item__name">Date</th>
                <th class="item__name">Time</th>
                <th class="item__name">Number</th>
            </tr>
            <tr class="reservation__content-detail">
                <td class="reservation__item">{{ $reservation->user->name }}</td>
                <td class="reservation__item">{{ $reservation->shop->name }}</td>
                <td class="reservation__item">{{ $reservation->reservation_date }}</td>
                <td class="reservation__item">{{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}</td>
                <td class="reservation__item">{{ $reservation->number_of_people }}</td>
            </tr>
        @endforeach
    </div>
@endsection