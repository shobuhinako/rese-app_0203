@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/import.css') }}">
@endsection

@section('content')
    @if(session()->has('success'))
            <p>{{ session('success') }}</p><br>
            保存したファイル名: {{ session('fileName') }}
    @endif

    @if ($errors->any() && !$errors->has('csv_errors'))
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->get('csv_errors') as $error)
                    <li class="error__message">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="error__message">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container">
        <h2 class="title">店舗情報CSVインポート</h2>
        <div class="image__upload">画像アップロード</div>
        <form class="image__upload-form" action="{{ route('upload.image') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" name="image">
            <button class="upload__button" type="submit">画像アップロード</button>
        </form>

        <form action="{{ route('shop.import.csv') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="label" for="csv_file">CSVファイルを選択</label>
                <input type="file" name="csv_file" id="csv_file" class="form-control" required accept=".csv">
            </div>
            <div class="message">
                ※画像のアップロードが必要な場合はアップロードしてからCSVファイルの取り込みを行ってください
            </div>
            <button class="submit__button" type="submit" class="btn btn-primary">インポート</button>
        </form>
    </div>
@endsection
