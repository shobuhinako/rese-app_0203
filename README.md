# Rese

  飲食店予約サービス
  <img width="1280" alt="スクリーンショット 2024-11-11 14 37 54" src="https://github.com/user-attachments/assets/b02f3271-54c3-48a8-b9c3-1d1438a015aa">


## 目的
    飲食店一覧の閲覧、飲食店の予約、口コミ投稿のため


## URL
    http://localhost/login

## 機能一覧
    1. 会員登録
    2. ログイン
    3. ログアウト
    4. ユーザー情報取得
    5. ユーザー飲食店お気に入り一覧取得
    6. ユーザー飲食店予約情報取得
    7. 飲食店一覧取得
    8. 飲食店詳細取得
    9. 飲食店お気に入り追加
    10. 飲食店お気に入り削除
    11. 飲食店予約情報追加
    12. 飲食店予約情報削除
    13. 飲食店検索（エリア、ジャンル、店名）
    14. 予約変更
    15. 本人確認
    16. 管理者作成（管理者のみ）
    17. 店舗代表者作成（管理者のみ）
    18. 店舗情報更新（店舗代表者のみ）
    19. 画像アップロード
    20. お知らせ配信
    21. 予約リマインダー
    22. QRコード表示、予約確認（店舗代表者のみ）
    23. 決済
    24. 口コミ新規作成、編集（一般ユーザーのみ）
        ※口コミの新規作成は予約後、予約時間を過ぎてから可能
    25. 口コミ削除（一般ユーザー、管理者のみ）
    26. 店舗一覧ソート
    27. csvインポート



## 使用技術（実行環境）
    laravel 8.83.27



## テーブル設計
![rese-app_0203](https://github.com/user-attachments/assets/8205206a-67d9-446b-98f7-ec099d378151)



## 環境構築
    1. コンテナの起動とビルド
       docker-compose up -d --build
    2. コンテナにアクセス
       docker-compose exec php bash
    3. 依存パッケージのインストール
       composer install
    4. .env.exampleファイルから.envを作成し、環境変数を変更
       cp .env.example .env
    5. アプリケーションキーの生成
       php artisan key:generate
    6. シンボリックリンクの作成
       php artisan storage:link
    7. マイグレーションの実施
       php artisan migrate
    8. シーディングの実施
       php artisan db:seed



## テストアカウント
    パスワードはすべて共通でpassword
    1. admin@gmail.com（管理者アカウント）
    2. tarou@gmail.com（店舗代表者アカウント）
    3. jirou@gmail.com（店舗代表者アカウント）
    4. sabrou@gmail.com（店舗代表者アカウント）
    5. testtarou@gmail.com（一般ユーザーアカウント）



## csvファイルアップロード方法
    1. http://localhost/の右上のcsvインポートボタンを押下（管理者でログインした場合のみ表示）
       もしくは店舗代表者アカウントでログインし、Manager Mypageの店舗作成、画像アップロードを押下。
    2. 店舗画像のアップロード
        「ファイルを選択」より画像ファイルを選択して「画像アップロード」ボタンを押下
        一意のファイル名が表示されるのでメモしておく
    3. Excelにインポートしたい情報を記載してcsv(コンマ区切り)(.csv)で保存
        1行目はヘッダーとして項目名を各セルに記載（ユーザーID、店舗名、エリア、ジャンル、店舗情報、画像ファイル名）
        2行目以降の各セルにそれぞれの項目の情報を記載
        ※ユーザーIDは2,3,4のいずれかを記載（テストアカウントの店舗代表者ユーザー）
        ※店舗名は50文字以内で記載
        ※エリアは「東京都」「大阪府」「福岡県」のいずれかを記載
        ※ジャンルは「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれかを記載
        ※店舗情報は400文字以内で記載
        ※画像ファイル名には画像アップロードした時に表示されたファイル名を記載（手順2でメモした内容）
    4. csvファイルを選択の選択ボタンからインポートしたいファイルを選択し、「インポート」を押下


## csvファイル例
  ![2DEA7BEB-2DD0-4407-B397-C3A66083F5A6_4_5005_c](https://github.com/user-attachments/assets/90afd348-56b8-463d-887b-420e47343909)
