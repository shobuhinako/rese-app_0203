@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/display-reviews.css') }}">
@endsection

@section('content')
    @if(session()->has('success'))
            <p>{{ session('success') }}</p>
    @endif

    <div class="tabs">
        <ul class="tab-titles">
            <li class="tab-title active" data-tab="reviews">口コミ</li>
            <li class="tab-title" data-tab="images">画像</li>
        </ul>

        @if (!$reviews->isEmpty())
            <div class="tab-content reviews-tab active" id="reviews">
                @foreach ($reviews as $review)
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

                        @if(Auth::user()->role_id == 1)
                            <div class="delete__review">
                                <form class="delete__link" action="{{ route('delete.review', ['shop_id' => $review->shop_id]) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $review->user_id }}">
                                    <input type="hidden" name="shop_id" value="{{ $review->shop_id }}">
                                    <input class="delete__link-button" type="submit" value="口コミを削除">
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="message">この店舗にはまだ口コミがありません。</P>
        @endif

        @if (!$reviews->isEmpty())
            <div class="tab-content images-tab" id="images">
                <div class="images-gallery">
                    @foreach ($reviews as $review)
                        @if (!empty($review->image_path))
                            <div class="image__item">
                                <img src="{{ Storage::url('images/' . $review->image_path) }}">
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <script src="{{ asset('js/display-reviews-script.js') }}"></script>
@endsection