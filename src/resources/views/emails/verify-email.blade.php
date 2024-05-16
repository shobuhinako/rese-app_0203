<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>本人確認メール</title>
</head>
<body>
    <p>こんにちは、{{ $userName }} 様</p>
    <p>以下のボタンをクリックして本人確認を完了してください。</p>
    <form method="get" action="{{ route('verification.verify', ['id' => $userId, 'hash' => $hash]) }}">
        @csrf
        <input type="hidden" name="id" value="{{ $userId }}">
        <input type="hidden" name="hash" value="{{ $hash }}">
        <button type="submit">本人確認を完了する</button>
    </form>
</body>
</html>
