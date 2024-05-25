@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/manager-mypage.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
<div class="top">
    <h1 class="top__content">{{ $user->name }}さん</h1>
</div>

<div class="manage__shop">
    <div class="create__shop-new">
        <form class="create__form" action="{{ route('shop.create.show') }}" method="get">
        @csrf
            <input type="submit" value="店舗作成">
        </form>
    </div>

    <div class="update__store-information">
        <form class="create__form" action="{{ route('shop.update.show') }}" method="get">
        @csrf
            <input type="submit" value="店舗情報更新">
        </form>
    </div>

    <div class="upload__image">
        <form class="upload__form" action="{{ route('upload.form') }}" method="get">
        @csrf
            <input type="submit" value="画像アップロード">
        </form>
    </div>

    <div class="reservation__status">
        <p class="reservation__status-title">
            予約状況
        </p>
        @foreach ($reservations as $reservation)
        <table class="reservation__content">
            <tr class="reservation__content-row">
                <th class="reservation__item-name">Name</th>
                <td class="reservation__item">{{ $reservation->user->name }}</td>
            </tr>
            <tr class="reservation__content-row">
                <th class="reservation__item-name">Shop</th>
                <td class="reservation__item">{{ $reservation->shop->name }}</td>
            </tr>
            <tr class="reservation__content-row">
                <th class="reservation__item-name">Date</th>
                <td class="reservation__item">{{ $reservation->reservation_date }}</td>
            </tr>
            <tr class="reservation__content-row">
                <th class="reservation__item-name">Time</th>
                <td class="reservation__item">{{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}</td>
            </tr>
            <tr class="reservation__content-row">
                <th class="reservation__item-name">Number</th>
                <td class="reservation__item">{{ $reservation->number_of_people }}</td>
            </tr>
        </table>
        <br />
        @endforeach
    </div>
@endsection