@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

    <div class="main">
        <div class="main__text">{{ $user->name }}さんお疲れ様です！</div>
        <p>{{session('message')}}</p>

        <div class="main__attendance-button">
            <form class="main__attendance-item" action="{{ route('punchin') }}" method="post">
            @csrf
                @if($punchin==null)
                <input type="submit" name="" value="勤務開始" style="background-color:yellow;" />
                @else
                <input type="submit" disabled name="" value="勤務開始" style="background-color:gray;" />
                @endif
            </form>

            <form class="main__attendance-item" action="{{ route('punchout') }}" method="post">
            @csrf
                <!-- 休憩取得しない場合 -->
                @if($punchin<>null && $punchout==null && $breakin==null && $breakout==null)
                <input type="submit" name="" value="勤務終了" style="background-color:yellow;" />
                <!-- 休憩取得する場合 -->
                @elseif($punchin<>null && $punchout==null && $breakin<>null && $breakout<>null)
                <input type="submit" name="" value="勤務終了" style="background-color:yellow;" />
                @else
                <input type="submit" disabled name="" value="勤務終了" style="background-color:gray;" />
                @endif
            </form>

            <form class="main__attendance-item" action="{{ route('breakin') }}" method="post">
            @csrf
                <!-- 1回目 -->
                @if($punchin <> null && $punchout == null && $breakin == null && $breakout==null)
                <input type="submit" name="" value="休憩開始" style="background-color:yellow;"  />
                <!-- n回目 -->
                @elseif($punchin <> null && $punchout == null && $breakin <> null && $breakout<>null)
                <input type="submit" name="" value="休憩開始" style="background-color:yellow;"  />
                @else
                <input type="submit" disabled name="" value="休憩開始" style="background-color:gray;" />
                @endif
            </form>

            <form class="main__attendance-item" action="{{ route('breakout') }}" method="post">
            @csrf
                <!-- 1回目 -->
                @if($punchin <> null && $punchout == null && $breakin <> null && $breakout==null)
                <input type="submit" name="" value="休憩終了" style="background-color:yellow;"  />
                <!-- n回目 -->
                @elseif($punchin <> null && $punchout == null && $breakin > $breakout)
                <input type="submit" name="" value="休憩終了" style="background-color:yellow;"  />
                @else
                <input type="submit" disabled name="" value="休憩終了" style="background-color:gray;" />
                @endif
            </form>

        </div>
    </div>
@endsection