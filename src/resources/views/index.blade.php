@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
<header class="search__area">
        <form class="search__form" action="{{ route('search') }}" method="get">
            @csrf
            <select name="area">
                <option value="all">All area</option>
                <option value="tokyo">東京都</option>
                <option value="osaka">大阪府</option>
                <option value="fukuoka">福岡県</option>
            </select>
            <select name="genre">
                <option value="all">All genre</option>
                <option value="italian">イタリアン</option>
                <option value="ramen">ラーメン</option>
                <option value="izakaya">居酒屋</option>
                <option value="sushi">寿司</option>
                <option value="yakiniku">焼肉</option>
            </select>
            <div class="search__box">
                <button id="search-button" type="submit"><i class="fa-solid fa-search"></i></button>
                <input type="text" name="name" value="{{ old('text') }}" placeholder="Search ...">
            </div>
        </form>
    </header>

    <div class="main">
        @foreach($shops as $shop)
        <div class="card">
            <div class="card__img">
                <img src="{{ Storage::url($shop->image_path) }}" alt="店舗画像" />
            </div>
            <div class="card__content">
                <h2 class="card__content-ttl">{{ $shop->name }}</h2>
            </div>
            <div class="card__content-tag">
                <p class="card__content-tag-item">#{{ $shop->area }}</p>
                <p class="card__content-tag-item">#{{$shop->genre }}</p>
            </div>
            <div class="detail">
                <form class="detail__button" action="{{ route('shop_detail', $shop->id) }}" method="get">
                @csrf
                <input type="submit" name="submit" value="詳しくみる">
                </form>
            </div>
            <div class="favorite">
                <form class="favorite__content" action="{{ route('favorite', ['shop' => $shop->id]) }}" method="post">
                @csrf
                    <button class="favorite__button" type="submit">
                    @if($shop->is_bookmarked_by_auth_user())
                        <i class="fa-solid fa-heart" style="color: #ec0426;"></i>
                    @else
                        <i class="fa-solid fa-heart" style="color: #a7a0a1;"></i>
                    @endif
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
@endsection