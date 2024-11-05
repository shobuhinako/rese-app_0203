@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="search__area">
        <form class="search__form" action="" method="">
        @csrf
            <select class="area" name="area">
                <option value="all">All area</option>
                <option value="tokyo">東京都</option>
                <option value="osaka">大阪府</option>
                <option value="fukuoka">福岡県</option>
            </select>
            <select class="genre" name="genre">
                <option value="all">All genre</option>
                <option value="italian">イタリアン</option>
                <option value="ramen">ラーメン</option>
                <option value="izakaya">居酒屋</option>
                <option value="sushi">寿司</option>
                <option value="yakiniku">焼肉</option>
            </select>
            <button class="search__button" id="search-button" type="submit"><i class="fa-solid fa-search"></i>
                <input class="search__text" type="text" name="name" value="{{ old('text') }}" placeholder="Search ...">
            </button>
        </form>
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
                <div class="card__content-tag-item">#{{ $shop->area }}</div>
                <div class="card__content-tag-item">#{{$shop->genre }}</div>
            </div>
            <div class="detail">
                <form class="detail__button" action="" method="">
                @csrf
                <input class="detail__button" type="submit" name="submit" value="詳しくみる">
                </form>
                <div class="favorite">
                    <form class="favorite__content" action="" method="">
                    @csrf
                        <button class="favorite__button" type="submit">
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection