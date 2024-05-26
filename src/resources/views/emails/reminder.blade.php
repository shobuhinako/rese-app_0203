# 予約リマインダー

{{ $reservation->user->name }}さん,

あなたの本日の予約です。以下の詳細をご確認ください。

**店舗:** {{ $reservation->shop->name }}
**日付:** {{ $reservation->reservation_date }}
**時間:** {{ $reservation->reservation_time }}
**人数:** {{ $reservation->number_of_people }}

Thanks,
{{ config('app.name') }}