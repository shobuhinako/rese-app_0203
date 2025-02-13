@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/reservation-status.css') }}">
@endsection

@section('content')
    <div class="reservation__status">
        <div class="shop__name">{{ $shop->name }}</div>

        @if($reservations->isEmpty())
            <p>本日の予約は入っていません。</p>
        @else
            <table class="reservation__content">
                <tr class="reservation__content-row">
                    <th class="reservation__item-name">予約者名</th>
                    <th class="reservation__item-name">日付</th>
                    <th class="reservation__item-name">時間</th>
                    <th class="reservation__item-name">人数</th>
                </tr>
                @foreach($reservations as $reservation)
                    <tr class="reservation__content-row">
                        <td class="reservation__item">{{ $reservation->user->name }}</td>
                        <td class="reservation__item">{{ $reservation->reservation_date }}</td>
                        <td class="reservation__item">{{ $reservation->reservation_time }}</td>
                        <td class="reservation__item">{{ $reservation->number_of_people }}</td>
                    </tr>
                @endforeach
            </table>
        @endif
    </div>
@endsection