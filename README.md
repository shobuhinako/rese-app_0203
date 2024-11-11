# Rese

  飲食店予約サービス
  <img width="1280" alt="スクリーンショット 2024-11-11 14 37 54" src="https://github.com/user-attachments/assets/b02f3271-54c3-48a8-b9c3-1d1438a015aa">



## 目的

    飲食店一覧の閲覧、飲食店の予約、口コミ投稿のため


## URL

    git@github.com:shobuhinako/coachtech-pro-test_1105.git
    会員登録画面にて会員登録を行なった後、ログイン画面からログインして使用



## 機能一覧
    1. 会員登録
    2. ログイン
    3. ログアウト
    4. 飲食店一覧取得
    5. 飲食店詳細取得
    6. 飲食店お気に入り追加
    7. 飲食店お気に入り削除
    8. 飲食店予約
    9. 飲食店検索（エリア、ジャンル、店名）
    10. 口コミ新規作成、編集（一般ユーザーのみ）
        ※口コミの新規作成は予約後、予約時間を過ぎてから可能
    11. 口コミ削除（一般ユーザー、管理者のみ）
    12. 店舗一覧ソート
    13. csvインポート

    No.10〜No.13がテスト対象の機能
 



## 使用技術（実行環境）

  laravel 8.83.8



## テーブル設計
  ![2024-11-11 16 51のイメージ](https://github.com/user-attachments/assets/97d2f0ae-8055-4239-a18e-fe58328c65eb)





## 環境構築
    1. コンテナの起動とビルド
       docker-compose up -d --build
    2. コンテナにアクセス
       docker-compose exec php bash
    3. 依存パッケージのインストール
       composer install
    4. .env.exampleファイルから.envを作成し、環境変数を変更
    5. アプリケーションキーの生成
       php artisan key:generate
    6. シンボリックリンクの作成
       php artisan storage:link



## テストアカウント
    パスワードはすべて共通でpassword
    管理者アカウント、店舗代表者アカウントを使用するときは以下のアカウントを使用する
    1. admin@gmail.com（管理者アカウント）
    2. tarou@gmail.com（店舗代表者アカウント）
    3. jirou@gmail.com（店舗代表者アカウント）
    4. sabrou@gmail.com（店舗代表者アカウント）
    5. testtarou@gmail.com（一般ユーザーアカウント）
