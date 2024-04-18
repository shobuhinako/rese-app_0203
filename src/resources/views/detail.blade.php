@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="detail">
    <form class="return__button" action="/" method="get">
        @csrf
        <input type="submit" name="submit" value="<">
    </form>
        <h2>{{ $shop->name }}</h2>
    <div class="card__img">
        <img src="{{ asset($shop->image_path) }}" alt="店舗画像" />
    </div>
    <div class="card__content-tag">
        <p class="card__content-tag-item">#{{ $shop->area }}</p>
        <p class="card__content-tag-item">#{{ $shop->genre }}</p>
    </div>
    <div class="shop__detail">
        <p class="shop__detail-item">{{ $shop->detail }}</p>
    </div>

<div class="reservation">
    <div class="reservation__title">
        <p class="reservation__title-white">予約</p>
    </div>
    <form class="reservation__form" action="/done" method="post">
    @csrf
        <input type="date" name="date" id="date-input">
        <select name="time">
                <option value="10:00">10:00</option>
                <option value="10:30">10:30</option>
                <option value="11:00">11:00</option>
                <option value="11:30">11:30</option>
                <option value="12:00">12:00</option>
                <option value="12:30">12:30</option>
                <option value="13:00">13:00</option>
                <option value="13:30">13:30</option>
                <option value="14:00">14:00</option>
                <option value="14:30">14:30</option>
                <option value="15:00">15:00</option>
                <option value="15:30">15:30</option>
                <option value="16:00">16:00</option>
                <option value="16:30">16:30</option>
                <option value="17:00">17:00</option>
                <option value="17:30">17:30</option>
                <option value="18:00">18:00</option>
                <option value="18:30">18:30</option>
                <option value="19:00">19:00</option>
                <option value="19:30">19:30</option>
                <option value="20:00">20:00</option>
                <option value="20:30">20:30</option>
                <option value="21:00">21:00</option>
        </select>
        <select name="number of people">
            <option value="1人">1人</option>
            <option value="2人">2人</option>
            <option value="3人">3人</option>
            <option value="4人">4人</option>
            <option value="5人">5人</option>
            <option value="6人">6人</option>
            <option value="7人">7人</option>
            <option value="8人">8人</option>
            <option value="9人">9人</option>
            <option value="10人">10人</option>
        </select>
    </form>

    <div class="reservation__content">
        <table class="reservation__detail">
            <tr class="reservation__detail-row">
                <th class="reservation__item-name">Shop</th>
                <td class="reservation__item">仙人</td>
            </tr>
            <tr class="reservation__detail-row">
                <th class="reservation__item-name">Date</th>
                <td class="reservation__item">2021-04-01</td>
            </tr>
            <tr class="reservation__detail-row">
                <th class="reservation__item-name">Time</th>
                <td class="reservation__item">17:00</td>
            </tr>
            <tr class="reservation__detail-row">
                <th class="reservation__item-name">Number</th>
                <td class="reservation__item">1人</td>
            </tr>
        </table>
    </div>

    <div class="reservation__footer">
        <form class="reservation__button" action="" method="post">
        @csrf
            <input type="submit" name="button" value="予約する">
        </form>
    </div>

@endsection