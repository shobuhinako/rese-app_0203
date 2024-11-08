@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
@endsection

@section('content')

    @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li class="error__message">{{$error}}</li>
            @endforeach
        </ul>
    @endif

    <div class="main">
        <div class="left">
            <div class="top__message">
                <p class="top__message-content">今回のご利用はいかがでしたか？</p>
            </div>
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
                    <form class="detail__button" action="{{ route('shop_detail', $shop->id) }}" method="get">
                    @csrf
                        <input class="detail__button" type="submit" name="submit" value="詳しくみる">
                    </form>
                </div>
            </div>
        </div>

        <div class="right">
            <form class="review__form" action="{{ route('review.store') }}" method="post" enctype="multipart/form-data">
            @csrf
                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                <div class="rate">
                    <div class="rate__message">体験を評価してください</div>
                    <div class="stars">
                        <span>
                            <input id="review01" type="radio" name="rating" value=5><label for="review01">★</label>
                            <input id="review02" type="radio" name="rating" value=4><label for="review02">★</label>
                            <input id="review03" type="radio" name="rating" value=3><label for="review03">★</label>
                            <input id="review04" type="radio" name="rating" value=2><label for="review04">★</label>
                            <input id="review05" type="radio" name="rating" value=1><label for="review05">★</label>
                        </span>
                    </div>
                </div>
                <div class="comment">
                    <div class="comment__title">口コミを投稿</div>
                    <textarea class="comment__text" name="comment" cols="80" rows="5" onkeyup="ShowLength(value);" placeholder="カジュアルな夜のお出かけにおすすめのスポット"></textarea>
                    <div class="count" id="inputlength">0/400（最高文字数）</div>
                </div>

                <div class="image">
                    <div class="image__title">画像の追加</div>
                    <button class="upload__button" id="upload-button">クリックして写真を追加</br>またはドラッグアンドドロップ
                        <input class="file__input" type="file" accept="image/jpeg, image/png" name="image">
                        <div id="preview"></div>
                    </button>
                </div>
                <div class="button">
                    <button class="submit__button" type="submit">口コミを投稿</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function ShowLength( str ) {
            document.getElementById("inputlength").innerHTML = str.length + "/400（最高文字数）";
        }
    </script>
    <script src="{{ asset('js/review-script.js') }}"></script>
@endsection