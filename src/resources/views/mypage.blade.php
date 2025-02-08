@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')

<div class="top">
    <div class="user__name">{{ $user->name }}さん</div>
</div>

<div class="content">
    <div class="main__content-left">
        <div class="main__title">予約状況</div>
        @foreach($reservations as $index => $reservation)
            <div class="reservation__card">
                <div class="reservation__status">
                    <div class="reservation__number">
                        <i class="fa-regular fa-clock" style="color: white;"></i>
                        <div class="reservation__title">予約{{ $index + 1 }}</div>
                    </div>
                    <form class="delete__reservation" action="{{ route('reservation.remove', $reservation->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                        <input class="delete__button" type="submit" value="×">
                    </form>
                </div>
                <table class="reservation__content">
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
                        <td class="reservation__item">{{ $reservation->formatted_reservation_time }}</td>
                    </tr>
                    <tr class="reservation__content-row">
                        <th class="reservation__item-name">Number</th>
                        <td class="reservation__item">{{ $reservation->number_of_people }}</td>
                    </tr>
                </table>
                <form class="reservation__change" action="{{ route('reservation.edit', ['id' => $reservation->id, 'shop_name' => $reservation->shop->name]) }}" method="get">
                @csrf
                    <input class="reservation__change-button" type="submit" value="予約変更">
                </form>
            </div>
        @endforeach
    </div>

    <div class="main__content-right">
        <div class="main__title">お気に入り店舗</div>
        <div class="favorite__shops-lists">
            @foreach($favoriteShops as $favoriteShop)
                <div class="card">
                    <div class="card__img">
                        <img class="img" src="{{ Storage::url('images/'.$favoriteShop->image_path) }}" alt="店舗画像" />
                    </div>
                    <div class="card__content">
                        <h2 class="card__content-ttl">{{ $favoriteShop->name }}</h2>
                    </div>
                    <div class="card__content-tag">
                        <div class="card__content-tag-item">#{{ $favoriteShop->area->area }}</div>
                        <div class="card__content-tag-item">#{{$favoriteShop->genre->genre }}</div>
                    </div>
                    <div class="detail">
                        <form class="detail__button" action="{{ route('shop.detail', $favoriteShop->id) }}" method="get">
                        @csrf
                            <input class="detail__button-item" type="submit" name="submit" value="詳しくみる">
                        </form>

                        <form class="favorite__button" action="{{ route('favorite.destroy', ['shop_id'=>$favoriteShop->id]) }}" method="post">
                        @csrf
                        @method('DELETE')
                            <button class="favorite__button-item" type="submit">
                                <i class="fa-solid fa-heart" style="color: #ec0426;"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
