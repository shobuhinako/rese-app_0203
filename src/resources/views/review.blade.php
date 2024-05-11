@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
@endsection

@section('content')
<div class="review">
    <div class="review__title">
        レビュー
    </div>

    <div class="review__content">
        <form class="review__form" action="/done/review" method="post">
        @csrf
            <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
            <table class="review__content-detail">
                <tr class="review__content-row">
                    <th class="review__item-name">店舗名
                    </th>
                        <td class="review__item">{{ $shop_name }}</td>
                </tr>
                <tr class="review__content-row">
                    <th class="review__item-name">評価
                    </th>
                        <td class="review__item">
                            <select name="point" id="point">
                                    <option value="1">1. 不満</option>
                                    <option value="2">2.やや不満 </option>
                                    <option value="3">3. 満足</option>
                                    <option value="4">4. かなり満足</option>
                                    <option value="5">5. 大変満足</option>
                            </select>
                        </td>
                </tr>
                <tr class="review__content-row">
                    <th class="review__item-name">コメント
                    </th>
                    <td class="review__item">
                        <textarea name="comment" cols="50" rows="10">
                        </textarea>
                    </td>
                </tr>
            </table>

            <div class="submit__button">
                <input type="submit" name="submit" value="送信">
            </div>
        </form>
    </div>
</div>
@endsection