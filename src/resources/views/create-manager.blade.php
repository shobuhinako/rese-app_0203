@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create-manager.css') }}">
@endsection

@section('content')
    @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif
    @if(session()->has('success_message'))
            <p>{{ session('success_message') }}</p>
    @endif
    <div class="register__content">
        <div class="register__title">店舗代表者作成</div>
        <div class="main__form">
            <form class="main__form-content" action="{{ route('manager.create') }}"
            method="post">
                @csrf
                <input type="hidden" name="role_id" value="2">
                <div>
                    <label for="shop_id">店舗を選択:</label>
                        <select name="shop_id" id="shop_id">
                            @foreach($shops as $shop)
                                <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                            @endforeach
                        </select>
                </div>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Username">
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email">
                <input type="password" name="password" placeholder="Password">
                <input type="submit" name="submit" value="登録">
            </form>
        </div>
    </div>


@endsection