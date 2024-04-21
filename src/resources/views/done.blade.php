@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
    <div class="done__content">
        <div class="done__message">ご予約ありがとうございます</div>
        <div class="back">
            <!-- <form class="back__button" action="route {{ ('back') }}" method="get">
                @csrf
                <input type="submit" name="submit" value="戻る">
            </form> -->
            <button type="submit" @if($previousUrl) onclick="location.href='{{ url($previousUrl ?? '') }}'" @else onclick="location.href='{{ url('/') }}'" @endif>戻る</button>
        </div>
    </div>
@endsection