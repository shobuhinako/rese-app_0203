@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div class="reservation__status">
        <h1 class="shop__name">{{ $shop->name }}</h1>

        @if($reservations->isEmpty())
            <p>本日の予約は入っていません。</p>
        @else
        <table class="reservation__content">
            @foreach($reservations as $reservation)
                <tr class="reservation__content-row">
                    <th class="reservation__item-name">`    予約者名</th>
                        <td class="reservation__item">{{ $reservation->user->name }}</td>
                    </tr>
                <tr class="reservation__content-row">
                    <th class="reservation__item-name">日付</th>
                        <td class="reservation__item">{{ $reservation->reservation_date }}</td>
                </tr>
                <tr class="reservation__content-row">
                    <th class="reservation__item-name">時間</th>
                        <td class="reservation__item">{{ $reservation->reservation_time }}</td>
                </tr>
                <tr class="reservation__content-row">
                    <th class="reservation__item-name">人数</th>
                        <td class="reservation__item">{{ $reservation->number_of_people }}</td>
                </tr>
            @endforeach
        </table>
        @endif
    </div>
@endsection