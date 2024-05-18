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
        <div class="register__title">管理者登録</div>
        <div class="main__form">
            <form class="main__form-content" action="{{ route('admin.create') }}" method="post">
                @csrf
                <input type="hidden" name="role_id" value="1">
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Username">
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email">
                <input type="password" name="password" placeholder="Password">
                <!-- <input type="password" name="password_confirmation" placeholder="確認用パスワード"> -->
                <input type="submit" name="submit" value="登録">
            </form>
        </div>
    </div>


@endsection