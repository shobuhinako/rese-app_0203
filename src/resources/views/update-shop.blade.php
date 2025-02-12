@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/update-shop.css') }}">
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
        <div class="register__title">店舗更新</div>
        <div class="main__form">
            <form class="main__form-content" action="{{ route('shop.update' , ['shop' => $shops->first()->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="item__name">
                    <label for="name">店舗名:</label>
                    <select class="select__box" name="name" id="name">
                    @foreach($shops as $shop)
                        <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                    @endforeach
                    </select>
                </div>

                <div class="item__name">
                    <label for="area">エリア:</label>
                    <select class="select__box" name="area" id="area" required>
                        <option value="">エリアを選択してください</option>
                        <option value="東京都" {{ old('area') == '東京都' ? 'selected' : '' }}>東京都</option>
                        <option value="大阪府" {{ old('area') == '大阪府' ? 'selected' : '' }}>大阪府</option>
                        <option value="福岡県" {{ old('area') == '福岡県' ? 'selected' : '' }}>福岡県</option>
                    </select>
                </div>

                <div class="item__name">
                    <label for="genre">ジャンル:</label>
                    <select class="select__box" name="genre" id="genre" required>
                        <option value="">ジャンルを選択してください</option>
                        <option value="イタリアン" {{ old('area') == 'イタリアン' ? 'selected' : '' }}>イタリアン</option>
                        <option value="ラーメン" {{ old('area') == 'ラーメン' ? 'selected' : '' }}>ラーメン</option>
                        <option value="居酒屋" {{ old('area') == '居酒屋' ? 'selected' : '' }}>居酒屋</option>
                        <option value="寿司" {{ old('area') == '寿司' ? 'selected' : '' }}>寿司</option>
                        <option value="焼肉" {{ old('area') == '焼肉' ? 'selected' : '' }}>焼肉</option>
                    </select>
                </div>

                <div class="item__name">
                    <label class="label" for="detail">詳細情報:</label>
                    <textarea  class="textarea" name="detail" id="detail" placeholder="詳細情報を入力してください" required cols="30" rows="10">{{ old('detail') }}</textarea>
                </div>

                <div class="item__name">
                    <label for="image_path">画像を選択してください:</label>
                    <select class="select__box" name="image_path" id="image_path">
                        <option value="">画像を選択してください</option>
                        @foreach ($images as $image)
                        <option value="{{ asset('storage/' . str_replace('storage/app/public/', '', $image)) }}">{{ $image }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="image" id="selected_image_container">
                </div>

                <div class="update__button">
                    <input class="update__button-item" type="submit" name="submit" value="更新">
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