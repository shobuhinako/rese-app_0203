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
    <div class="detail__left">
        <div class="detail__header">
            <form class="return__button" action="/" method="get">
            @csrf
                <input class="return__button-item" type="submit" name="submit" value="<">
            </form>
            <div class="shop__name">{{ $shop->name }}</div>
        </div>

        <div class="card__img">
            <img class="shop__img" src="{{ Storage::url('images/' . $shop->image_path) }}" alt="店舗画像" />
        </div>

        <div class="card__content-tag">
            <div class="card__content-tag-item">#{{ $shop->area }}</div>
            <div class="card__content-tag-item">#{{ $shop->genre }}</div>
        </div>
        <div class="shop__detail">{{ $shop->detail }}</div>

        <!-- <form class="link" action="{{ route('show.review', $shop->id) }}" method="get">
        @csrf
            <input class="link__button" type="submit" value="口コミを投稿する">
        </form> -->

        <form class="all__review-link" action="{{ route('display.reviews', ['shop_id' => $shop->id]) }}" method="get">
        @csrf
            <input class="all__review-button" type="submit" value="全ての口コミ情報">
        </form>

        @if (Auth::user()->role_id === null)
            <div class="line"></div>
            @if (!$review)
                <form class="link" action="{{ route('show.review', $shop->id) }}" method="get">
                @csrf
                    <input class="link__button" type="submit" value="口コミを投稿する">
                </form>
            @else
                <div class="link__area">
                    <form class="edit__link" action="{{ route('show.review', $shop->id) }}" method="get">
                    @csrf
                        <input class="edit__link-button" type="submit" value="口コミを編集">
                    </form>
                    <form class="delete__link" action="{{ route('remove.review', $shop->id) }}" method="post">
                    @csrf
                        <input class="delete__link-button" type="submit" value="口コミを削除">
                    </form>
                </div>
            @endif
        @endif

        @if (Auth::user()->role_id === null)
            @if ($review)
                <div class="review">
                    <div class="review__rating">
                        <div class="stars">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="star {{ $i <= $review->rating ? 'filled' : 'unfilled' }}">★</span>
                            @endfor
                        </div>
                    </div>

                    <div class="review__comment">
                        <p class="comment">{{ $review->comment}}</p>
                    </div>
                </div>
            @else
                <div class="no__review">
                    <p class="no__review-message">まだ口コミは投稿されていません</p>
                </div>
            @endif
            <div class="line"></div>
        @endif
    </div>

    <div class="detail__right">
        <div class="reservation">
            <div class="reservation__title">予約</div>
            <form class="reservation__form" id="reservation-form" action="/done" method="post">
            @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                <div class="date">
                    <input class="reservation__date" type="date" name="reservation_date" id="date-input" onchange="showSelected()">
                </div>
                <div class="time">
                    <select class="reservation__time" name="reservation_time" id="time-input" onchange="showSelected()">
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
                </div>
                <div class="number">
                    <select class="number_of_people" name="number_of_people" id="number-input" onchange="showSelected()">
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
                </div>

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
                <div class="reservation__footer">
                        <input class="reservation__button" type="submit" value="予約する">
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateDate() {
            var selectedDate = document.getElementById("date-input").value;
            document.querySelector("#date-row .reservation__item").textContent = selectedDate;
        }

        function updateTime() {
            var selectedTime = document.getElementById("time-input").value;
            document.querySelector("#time-row .reservation__item").textContent = selectedTime;
        }

        function updateNumberOfPeople() {
            var selectedNumberOfPeople = document.getElementById("number-input").value;
            document.querySelector("#number-row .reservation__item").textContent = selectedNumberOfPeople;
        }

        function showSelected() {
            updateDate();
            updateTime();
            updateNumberOfPeople();
        }
    </script>
@endsection