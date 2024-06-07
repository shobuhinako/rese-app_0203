# Rese

  飲食店予約サービス
  ![image](https://github.com/shobuhinako/rese-app/assets/142642424/5e5b9a0b-c6b7-4606-a361-f43bdc471591)


## 目的

  外部の飲食店予約サービスは手数料を取られるので自社で予約サービスを持ちたいという要望のため開発


## URL

  git@github.com:shobuhinako/rese-app.git  
  会員登録画面にて会員登録を行なった後、ログイン画面からログインして使用（ログインには本人確認が必要）



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
  15. 評価
  16. 本人確認
  17. 管理者作成（管理者のみ）
  18. 店舗代表者作成（管理者のみ）
  19. 店舗情報作成、更新（店舗代表者のみ）
  20. 画像アップロード
  21. お知らせ配信
  22. 予約リマインダー
  23. QRコード表示、予約確認（店舗代表者のみ）
  24. 決済



## 使用技術（実行環境）

  laravel 8.83.27



## テーブル設計
![image](https://github.com/shobuhinako/rese-app/assets/142642424/ea557314-27b5-4b61-b570-30dd8fa23cc4)



## 環境構築
1. docker-compose exec php bash
2. composer install
3. .env.exampleファイルから.envを作成し、環境変数を変更
4. php artisan key:generate
5. php artisan migrate
6. php artisan db:seed



## テストアカウント
パスワードはすべて共通でpassword
1. admin@gmail.com（管理者アカウント）
2. tarou@gmail.com（店舗代表者アカウント）
3. jirou@gmail.com（店舗代表者アカウント）
4. sabrou@gmail.com（店舗代表者アカウント）
5. testtarou@gmail.com（一般ユーザーアカウント）

メール送受信のテストの際は自分のアドレスを使用
