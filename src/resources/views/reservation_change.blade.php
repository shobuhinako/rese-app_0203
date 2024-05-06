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
                        @foreach ($timeOptions as $timeOption)
                        <option value="{{ $timeOption }}" @if (\Carbon\Carbon::parse($timeOption)->format('H:i') === $selectedTime->format('H:i')) selected @endif>{{ \Carbon\Carbon::parse($timeOption)->format('H:i') }}</option>
                        @endforeach
                        

                        <!-- <option value="10:00:00">10:00</option>
                        <option value="10:30:00">10:30</option>
                        <option value="11:00:00">11:00</option>
                        <option value="11:30:00">11:30</option>
                        <option value="12:00:00">12:00</option>
                        <option value="12:30:00">12:30</option>
                        <option value="13:00:00">13:00</option>
                        <option value="13:30:00">13:30</option>
                        <option value="14:00:00">14:00</option>
                        <option value="14:30:00">14:30</option>
                        <option value="15:00:00">15:00</option>
                        <option value="15:30:00">15:30</option>
                        <option value="16:00:00">16:00</option>
                        <option value="16:30:00">16:30</option>
                        <option value="17:00:00">17:00</option>
                        <option value="17:30:00">17:30</option>
                        <option value="18:00:00">18:00</option>
                        <option value="18:30:00">18:30</option>
                        <option value="19:00:00">19:00</option>
                        <option value="19:30:00">19:30</option>
                        <option value="20:00:00">20:00</option>
                        <option value="20:30:00">20:30</option>
                        <option value="21:00:00">21:00</option>
                    </select> -->
                </td>
            </tr>
            <tr class="reservation__content-row">
                <th class="reservation__item-name">Number</th>
                <td class="reservation__item">
                    <select name="number_of_people" id="number-input">
                        @foreach ($numberOfPeopleOptions as $option)
                        <option value="{{ $option }}" @if ($option === $reservationContent->number_of_people) selected @endif>{{ $option }}</option>
                        @endforeach
                        <!-- <option value="1人">1人</option>
                        <option value="2人">2人</option>
                        <option value="3人">3人</option>
                        <option value="4人">4人</option>
                        <option value="5人">5人</option>
                        <option value="6人">6人</option>
                        <option value="7人">7人</option>
                        <option value="8人">8人</option>
                        <option value="9人">9人</option>
                        <option value="10人">10人</option> -->
                    </select>
                </td>
            </tr>
        </table>
        <input type="submit" value="予約変更">
        </form>
    </div>
</div>

@endsection