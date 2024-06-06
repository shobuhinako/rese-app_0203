@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')

@if (count($errors) > 0)
<ul>
    @foreach ($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
</ul>
@endif

<div class="detail">
    <form class="return__button" action="/" method="get">
        @csrf
        <input type="submit" name="submit" value="<">
    </form>
        <h2>{{ $shop->name }}</h2>
    <div class="card__img">
        <img src="{{ Storage::url($shop->image_path) }}" alt="店舗画像" />
    </div>
    <div class="card__content-tag">
        <p class="card__content-tag-item">#{{ $shop->area }}</p>
        <p class="card__content-tag-item">#{{ $shop->genre }}</p>
    </div>
    <div class="shop__detail">
        <p class="shop__detail-item">{{ $shop->detail }}</p>
    </div>

        @if ($user && $user->role_id === 2)
            @if ($shop->isOwner($user->id))
                <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">
            @else
                <p>あなたはこの店舗の代表者ではないため、QRコードを表示できません。</p>
            @endif
        @endif

    <div class="reservation">
    <div class="reservation__title">
        <p class="reservation__title-white">予約</p>
    </div>
    <form class="reservation__form" id="reservation-form" action="/done" method="post">
    @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
        <input type="date" name="reservation_date" id="date-input" onchange="showSelected()">
        <select name="reservation_time" id="time-input" onchange="showSelected()">
                <option value="10:00:00">10:00</option>
                <option value="10:30:00">10:30</option>
                <option value="11:00:00">11:00</option>
                <option value="11:30:00">11:30</option>
                <option value="12:00:00">12:00</option>
                <option value="12:30:00">12:30</option>
                <option value="13:00:00">13:00</option>
                <option value="13:30:00">13:30</option>
                <option value="14:00:00">14:00</option>
                <option value="14:30:00">14:30</option>
                <option value="15:00:00">15:00</option>
                <option value="15:30:00">15:30</option>
                <option value="16:00:00">16:00</option>
                <option value="16:30:00">16:30</option>
                <option value="17:00:00">17:00</option>
                <option value="17:30:00">17:30</option>
                <option value="18:00:00">18:00</option>
                <option value="18:30:00">18:30</option>
                <option value="19:00:00">19:00</option>
                <option value="19:30:00">19:30</option>
                <option value="20:00:00">20:00</option>
                <option value="20:30:00">20:30</option>
                <option value="21:00:00">21:00</option>
        </select>
        <select name="number_of_people" id="number-input" onchange="showSelected()">
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

    <div class="reservation__content" id="reservation-content" >
        <table class="reservation__detail">
            <tr class="reservation__detail-row">
                <th class="reservation__item-name">Shop</th>
                <td class="reservation__item" id="shop-name">{{ $shop->name }}</td>
            </tr>
            <tr class="reservation__detail-row" id="date-row">
                <th class="reservation__item-name">Date</th>
                <td class="reservation__item"></td>
            </tr>
            <tr class="reservation__detail-row" id="time-row">
                <th class="reservation__item-name">Time</th>
                <td class="reservation__item"></td>
            </tr>
            <tr class="reservation__detail-row" id="number-row">
                <th class="reservation__item-name">Number</th>
                <td class="reservation__item"></td>
            </tr>
        </table>
    </div>

    <script>
    function updateDate() {
    var selectedDate = document.getElementById("date-input").value;
    var content = "<table class='reservation__detail'>";
    content += "<tr><th>Date</th><td>" + selectedDate + "</td></tr>";
    content += "</table>";
    document.getElementById("date-row").innerHTML = content;
    }


    // 時間が選択された時の処理
    function updateTime() {
    var selectedTime = document.getElementById("time-input").value;
    var content = "<table class='reservation__detail'>";
    content += "<tr><th>Time</th><td>" + selectedTime + "</td></tr>";
    content += "</table>";
    document.getElementById("time-row").innerHTML = content;
    }

    // 人数が選択された時の処理
    function updateNumberOfPeople() {
    var selectedNumberOfPeople = document.getElementById("number-input").value;
    var content = "<table class='reservation__detail'>";
    content += "<tr><th>Number of People</th><td>" + selectedNumberOfPeople + "</td></tr>";
    content += "</table>";
    document.getElementById("number-row").innerHTML = content;
    }

    // 日付、時間、人数が選択された時に呼び出される関数
    function showSelected() {
    updateDate();
    updateTime();
    updateNumberOfPeople();
    }
    </script>

    <div class="reservation__footer">
            <input type="submit" value="予約する">
    </div>
    </form>

@endsection