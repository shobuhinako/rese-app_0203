@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create-admin.css') }}">
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
        <div class="register__title">管理者作成</div>
        <div class="main__form">
            <form class="main__form-content" action="{{ route('admin.create') }}" method="post">
                @csrf
                <input type="hidden" name="role_id" value="1">
                <div class="text__box">
                    <input class="text__box-item" type="text" name="name" value="{{ old('name') }}" placeholder="Username">
                </div>
                <div class="text__box">
                    <input class="text__box-item" type="email" name="email" value="{{ old('email') }}" placeholder="Email">
                </div>
                <div class="text__box">
                    <input class="text__box-item" type="password" name="password" placeholder="Password">
                </div>
                <div class="submit__button">
                    <input class="submit__button-item" type="submit" name="submit" value="登録">
                </div>
            </form>
        </div>
    </div>


@endsection