@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reservation_change.css') }}">
@endsection

@section('content')

<div class="reservation">
    <h2 class="main__title">予約内容</h2>
    @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif
    <div class="reservation__content">
        <form class="reservation__change" action="{{ route('reservation.update', ['id' => $reservationContent->id]) }}" method="post">
            @csrf
            @method('PUT')
        <table class="reservation__content-detail">
            <tr class="reservation__content-row">
                <th class="reservation__item-name">Shop</th>
                <td class="reservation__item">{{ $shop_name }}</td>
            </tr>
            <tr class="reservation__content-row">
                <th class="reservation__item-name">Date</th>
                <td class="reservation__item">
                    <input type="date" name="reservation_date" id="date-input" value="{{ $reservationContent->reservation_date }}">
                </td>
            </tr>
            <tr class="reservation__content-row">
                <th class="reservation__item-name">Time</th>
                <td class="reservation__item">
                    <select name="reservation_time" id="time-input">
                    @foreach ($timeOptions as $index => $timeOption)
                    @php
                        $formattedTime = \Carbon\Carbon::parse($timeOption)->format('H:i');
                        $nextIndex = $index + 1;
                        $nextTimeOption = $timeOptions[$nextIndex] ?? null;
                        $nextFormattedTime = \Carbon\Carbon::parse($nextTimeOption)->format('H:i');
                    @endphp
                    @if ($nextTimeOption && $formattedTime !== $nextFormattedTime)
                        <option value="{{ $timeOption }}" @if ($formattedTime === $selectedTime->format('H:i')) selected @endif>{{ $formattedTime }}</option>
                    @endif
                    @endforeach
                </td>
            </tr>
            <tr class="reservation__content-row">
                <th class="reservation__item-name">Number</th>
                <td class="reservation__item">
                    <select name="number_of_people" id="number-input">
                        @foreach ($numberOfPeopleOptions as $option)
                        <option value="{{ $option }}" @if ($option === $reservationContent->number_of_people) selected @endif>{{ $option }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
        </table>
        <input type="submit" value="予約変更">
        </form>
    </div>
</div>

@endsection