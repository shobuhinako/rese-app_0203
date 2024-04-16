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
@endsection