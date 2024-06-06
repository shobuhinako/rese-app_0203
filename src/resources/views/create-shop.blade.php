@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create-shop.css') }}">
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
        <div class="register__title">店舗作成</div>
        <div class="main__form">
            <form class="main__form-content" action="{{ route('shop.create') }}" method="post">
                @csrf

                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                <div>
                    <label for="name">店舗名:</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="店舗名を入力してください" required>
                </div>

                <div>
                    <label for="area">エリア:</label>
                    <select name="area" id="area" required>
                        <option value="">エリアを選択してください</option>
                        <option value="東京都" {{ old('area') == '東京都' ? 'selected' : '' }}>東京都</option>
                        <option value="大阪府" {{ old('area') == '大阪府' ? 'selected' : '' }}>大阪府</option>
                        <option value="福岡県" {{ old('area') == '福岡県' ? 'selected' : '' }}>福岡県</option>
                    </select>
                </div>

                <div>
                    <label for="genre">ジャンル:</label>
                    <select name="genre" id="genre" required>
                        <option value="">ジャンルを選択してください</option>
                        <option value="イタリアン" {{ old('area') == 'イタリアン' ? 'selected' : '' }}>イタリアン</option>
                        <option value="ラーメン" {{ old('area') == 'ラーメン' ? 'selected' : '' }}>ラーメン</option>
                        <option value="居酒屋" {{ old('area') == '居酒屋' ? 'selected' : '' }}>居酒屋</option>
                        <option value="寿司" {{ old('area') == '寿司' ? 'selected' : '' }}>寿司</option>
                        <option value="焼肉" {{ old('area') == '焼肉' ? 'selected' : '' }}>焼肉</option>
                    </select>
                </div>

                <div>
                    <label for="detail">詳細情報:</label>
                    <textarea name="detail" id="detail" placeholder="詳細情報を入力してください" required>{{ old('detail') }}</textarea>
                </div>

                <div>
                    <label for="image_path">画像を選択してください:</label>
                    <select name="image_path" id="image_path">
                        <option value="">画像を選択してください</option>
                        @foreach ($images as $image)
                        <option value="{{ asset('storage/' . str_replace('storage/app/public/', '', $image)) }}">{{ $image }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="selected_image_container">
                </div>

                <div class="register__button">
                    <input type="submit" name="submit" value="登録">
                </div>
            </form>
        </div>
    </div>

<script>
    // 画像が選択されたときに実行する関数
    $('#image_path').change(function() {
        var selectedImage = $(this).val(); // 選択された画像のパスを取得
        $('#selected_image_container').html('<img src="' + selectedImage + '" alt="Selected Image">'); // 画像を表示する
    });
</script>


@endsection