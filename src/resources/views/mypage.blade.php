@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')

<div class="top">
    <h1 class="top__content">{{ $user->name }}さん</h1>
</div>
<div class="main__content-left">
    <h2 class="main__title">予約状況</h2>
    @foreach($reservationContents as $index => $reservationContent)

    <div class="reservation__status">
        <p class="reservation__title">予約{{ $index + 1 }}</p>
        <form class="delete__reservation" action="{{ route('reservation.remove', ['id'=>$reservationContent->id]) }}" method="post">
        @csrf
        @method('DELETE')
        <input type="submit" value="×">
        </form>
        <table class="reservation__content">
            <tr class="reservation__content-row">
                <th class="reservation__item-name">Shop</th>
                <td class="reservation__item">{{ $reservationContent->shop->name }}</td>
            </tr>
            <tr class="reservation__content-row">
                <th class="reservation__item-name">Date</th>
                <td class="reservation__item">{{ $reservationContent->reservation_date }}</td>
            </tr>
            <tr class="reservation__content-row">
                <th class="reservation__item-name">Time</th>
                <td class="reservation__item">{{ $reservationContent->formatted_reservation_time }}</td>
            </tr>
            <tr class="reservation__content-row">
                <th class="reservation__item-name">Number</th>
                <td class="reservation__item">{{ $reservationContent->number_of_people }}</td>
            </tr>
        </table>
        <form class="reservation__change" action="{{ route('reservation.edit', ['id' => $reservationContent->id, 'shop_name'=>$reservationContent->shop->name]) }}" method="get">
        @csrf
        <input type="submit" value="予約変更">
        </form>
    </div>
    @endforeach
</div>
<div class="main__content-right">
    <h2 class="main__title">お気に入り店舗</h2>
    @foreach($favoriteShops as $favoriteShop)
        <div class="card">
            <div class="card__img">
                <img src="{{ asset($favoriteShop->image_path) }}" alt="店舗画像" />
            </div>
            <div class="card__content">
                <h2 class="card__content-ttl">{{ $favoriteShop->name }}</h2>
            </div>
            <div class="card__content-tag">
                <p class="card__content-tag-item">#{{ $favoriteShop->area }}</p>
                <p class="card__content-tag-item">#{{$favoriteShop->genre }}</p>
            </div>
            <div class="detail">
                <form class="detail__button" action="{{ route('shop_detail', $favoriteShop->id) }}" method="get">
                @csrf
                <input type="submit" name="submit" value="詳しくみる">
                </form>
            </div>
            <div class="favorite__mark">
                <form class="favorite__button" action="{{ route('favorite.destroy', ['shop_id'=>$favoriteShop->id]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="favorite__button-item" type="submit">
                        <i class="fa-solid fa-heart" style="color: #ec0426;"></i>
                    </button>
                </form>
            </div>
    @endforeach
</div>
@endsection
