# Rese

  飲食店予約サービス
<<<<<<< HEAD
  ![image](https://github.com/shobuhinako/rese-app/assets/142642424/5e5b9a0b-c6b7-4606-a361-f43bdc471591)
=======
  <img width="1280" alt="スクリーンショット 2024-11-11 14 37 54" src="https://github.com/user-attachments/assets/b02f3271-54c3-48a8-b9c3-1d1438a015aa">

>>>>>>> coachtech-pro-test_1105/main


## 目的

<<<<<<< HEAD
  外部の飲食店予約サービスは手数料を取られるので自社で予約サービスを持ちたいという要望のため開発
=======
    飲食店一覧の閲覧、飲食店の予約、口コミ投稿のため
>>>>>>> coachtech-pro-test_1105/main


## URL

<<<<<<< HEAD
  git@github.com:shobuhinako/rese-app.git  
  会員登録画面にて会員登録を行なった後、ログイン画面からログインして使用（ログインには本人確認が必要）
=======
    git@github.com:shobuhinako/coachtech-pro-test_1105.git
    会員登録画面にて会員登録を行なった後、ログイン画面からログインして使用
>>>>>>> coachtech-pro-test_1105/main



## 機能一覧
<<<<<<< HEAD
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
=======
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
 
>>>>>>> coachtech-pro-test_1105/main



## 使用技術（実行環境）

<<<<<<< HEAD
  laravel 8.83.27
=======
  laravel 8.83.8
>>>>>>> coachtech-pro-test_1105/main



## テーブル設計
<<<<<<< HEAD
![image](https://github.com/shobuhinako/rese-app/assets/142642424/ea557314-27b5-4b61-b570-30dd8fa23cc4)
=======
  ![38323BCF-0A00-485A-A802-0A92DFA50A7F](https://github.com/user-attachments/assets/be7ad1d0-71f0-4072-bed9-001505c5e686)



>>>>>>> coachtech-pro-test_1105/main



## 環境構築
<<<<<<< HEAD
1. docker-compose exec php bash
2. composer install
3. .env.exampleファイルから.envを作成し、環境変数を変更
4. php artisan key:generate
5. php artisan migrate
6. php artisan db:seed
=======
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
>>>>>>> coachtech-pro-test_1105/main



## テストアカウント
<<<<<<< HEAD
パスワードはすべて共通でpassword
1. admin@gmail.com（管理者アカウント）
2. tarou@gmail.com（店舗代表者アカウント）
3. jirou@gmail.com（店舗代表者アカウント）
4. sabrou@gmail.com（店舗代表者アカウント）
5. testtarou@gmail.com（一般ユーザーアカウント）

メール送受信のテストの際は自分のアドレスを使用
=======
    パスワードはすべて共通でpassword
    管理者アカウント、店舗代表者アカウントを使用するときは以下のアカウントを使用する
    1. admin@gmail.com（管理者アカウント）
    2. tarou@gmail.com（店舗代表者アカウント）
    3. jirou@gmail.com（店舗代表者アカウント）
    4. sabrou@gmail.com（店舗代表者アカウント）
    5. testtarou@gmail.com（一般ユーザーアカウント）



## csvファイルアップロード方法
    1. http://localhost/の右上のcsvインポートボタンを押下（管理者でログインした場合のみ表示）
    2. 店舗画像のアップロード
        「ファイルを選択」より画像ファイルを選択して「画像アップロード」ボタンを押下
        一意のファイル名が表示されるのでメモしておく
    3. Excelにインポートしたい情報を記載してcsvで保存
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

        
>>>>>>> coachtech-pro-test_1105/main
