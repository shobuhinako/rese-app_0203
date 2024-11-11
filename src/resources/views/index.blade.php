@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="custom">
        @if (Auth::user()->role_id === null)
            <div class="sort__area">
                <form class="sort__form" action="{{ route('sort') }}" method="get">
                    @csrf
                    <select class="sort__type" name="sort__type" onchange="this.form.submit()">
                        <option value="">並び替え</option>
                        <option value="random" {{ request('sort__type') === 'random' ? 'selected' : '' }}>ランダム</option>
                        <option value="rating_asc" {{ request('sort__type') === 'rating_asc' ? 'selected' : '' }}>評価が高い順</option>
                        <option value="rating_desc" {{ request('sort__type') === 'rating_desc' ? 'selected' : '' }}>評価が低い順</option>
                    </select>
                </form>
            </div>
        @endif

        <div class="search__area">
            <form class="search__form" action="{{ route('search') }}" method="get">
                @csrf
                <select class="area" name="area">
                    <option value="all">All area</option>
                    <option value="1">東京都</option>
                    <option value="2">大阪府</option>
                    <option value="3">福岡県</option>
                </select>
                <select class="genre" name="genre">
                    <option value="all">All genre</option>
                    <option value="3">イタリアン</option>
                    <option value="5">ラーメン</option>
                    <option value="4">居酒屋</option>
                    <option value="1">寿司</option>
                    <option value="2">焼肉</option>
                </select>
                <button class="search__button" id="search-button" type="submit"><i class="fa-solid fa-search"></i>
                </button>
                <input class="search__text" type="text" name="name" value="{{ old('text') }}" placeholder="Search ...">
            </form>
        </div>

        @if (Auth::user()->role_id === 1)
            <div class="csv__import">
                <form class="csv__import-form" action="{{ route('show.import.form') }}" method="get">
                    @csrf
                    <input class="csv__import-button" type="submit" value="CSVインポート">
                </form>
            </div>
        @endif
    </div>

    <div class="main">
        @foreach($shops as $shop)
        <div class="card">
            <div class="card__img">
                <img class="img" src="{{ Storage::url('images/' . $shop->image_path) }}" alt="店舗画像" />
            </div>
            <div class="card__content">
                <h2 class="card__content-ttl">{{ $shop->name }}</h2>
            </div>
            <div class="card__content-tag">
                <div class="card__content-tag-item">#{{ $shop->area->area }}</div>
                <div class="card__content-tag-item">#{{$shop->genre->genre }}</div>
            </div>
            <div class="detail">
                <div class="detail__content">
                    <form class="detail__button" action="{{ route('shop_detail', $shop->id) }}" method="get">
                        @csrf
                        <input class="detail__button" type="submit" name="submit" value="詳しくみる">
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
        </div>
        @endforeach
    </div>
@endsection