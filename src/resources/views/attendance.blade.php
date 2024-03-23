@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
    <div class="main">
        <form action="{{ route('subday', ['dt' => $dt]) }}" method="post">
        @csrf
            <button type="submit"><</button>
        </form>
        <div class="main__header">
            {{ $dt }}
        </div>
        <form action="{{ route('adddate', ['dt' => $dt]) }}" method="post">
        @csrf
            <button type="submit">></button>
        </form>

        <table class="date__list">
            <tr>
                <th class="date__list-title">名前</th>
                <th class="date__list-title">勤務開始</th>
                <th class="date__list-title">勤務終了</th>
                <th class="date__list-title">休憩時間</th>
                <th class="date__list-title">勤務時間</th>
            </tr>
            @foreach($timestamps as $timestamp)
            <tr>
                <td class="date__list-item">{{ $timestamp->user_name }}</td>
                <td class="date__list-item">{{ $timestamp->punchIn }}</td>
                <td class="date__list-item">{{ $timestamp->punchOut }}</td>
                <td class="date__list-item">{{ $timestamp->total_break_time }}</td>
                <td class="date__list-item">{{ $timestamp->work_duration }}</td>
            </tr>
            @endforeach
        </table>
        {{ $timestamps->links() }}
    </div>
@endsection