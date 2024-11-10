<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ImageUploadRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Shop;
use App\Models\Favorite;
use App\Models\Review;

class ShopController extends Controller
{
    public function favorite(Request $request, Shop $shop){
        // 認証済みユーザーを取得
        $user = Auth::user();

        if ($user) {
            // Userのid取得
            $user_id = Auth::id();

        // 既にいいねしているかチェック
        $existingFavorite = Favorite::where('shop_id', $shop->id)
            ->where('user_id', $user_id)
            ->first();

        // 既にいいねしている場合は削除し、そうでない場合は新しいいいねを作成する
        if ($existingFavorite) {
            $existingFavorite->delete();
            $isFavorite = false;
        } else {
            $favorite = new Favorite();
            $favorite->shop_id = $shop->id;
            $favorite->user_id = $user_id;
            $favorite->save();
            $isFavorite = true;
        }

        session()->put('isFavorite', $isFavorite);
        session()->put('favoriteShopId', $shop->id);
        }
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $favorite = Favorite::where('shop_id', $request->shop_id)->first();
        if ($favorite) {
            $favorite->delete();
        }
        return redirect()->back();
    }

    public function search(Request $request)
    {
        $areaMapping = array(
            'tokyo' => '東京都',
            'osaka' => '大阪府',
            'fukuoka' => '福岡県',
        );

        $genreMapping = [
            'sushi' => '寿司',
            'italian' => 'イタリアン',
            'ramen' => 'ラーメン',
            'izakaya' => '居酒屋',
            'yakiniku' => '焼肉',
        ];

        // フォームから送信されたデータを取得
        $areaInput = $request->input('area');
        $genreInput = $request->input('genre');
        $name = $request->input('name'); // テキストボックスから送信されたお店の名前

        // エリアとジャンルをマッピング
        $area = $areaMapping[$areaInput] ?? null;
        $genre = $genreMapping[$genreInput] ?? null;

        // クエリビルダーを使用して、検索条件に基づいて店舗を取得
        $query = Shop::query();

        switch (true) {
            case (!empty($area) && !empty($genre) && !empty($name)):
                // エリア、ジャンル、店舗名がすべて指定されている場合
                $query->where('area', $area)->where('genre', $genre)->where('name', 'like', "%$name%");
                break;

            case (!empty($area) && !empty($genre)):
                // エリアとジャンルが指定されている場合
                $query->where('area', $area)->where('genre', $genre);
                break;

            case (!empty($area) && !empty($name)):
                // エリアと店舗名が指定されている場合
                $query->where('area', $area)->where('name', 'like', "%$name%");
                break;

            case (!empty($genre) && !empty($name)):
                // ジャンルと店舗名が指定されている場合
                $query->where('genre', $genre)->where('name', 'like', "%$name%");
                break;

            case (!empty($genre) && $area <> 'tokyo' && 'osaka' && 'fukuoka'):
                // ジャンルが指定されていて、エリアが全ての場合
                $query->where('genre', $genre)->whereIn('area', ['東京都', '大阪府', '福岡県']);
                break;

            case (!empty($area) && $genre <> 'sushi' && 'italian' && 'ramen' && 'izakaya' && 'yakiniku'):
                // エリアが指定されていて、ジャンルが全ての場合
                $query->where('area', $area)->whereIn('genre', ['寿司', 'イタリアン', 'ラーメン', '居酒屋', '焼肉']);
                break;

            case (!empty($name)):
                // 店舗名が指定されている場合
                $query->where('name', 'like', "%$name%");
                break;

            default:
                // 条件が指定されていない場合はすべての店舗を取得
                $query->whereNotNull('id');
                break;
        }

        // 店舗を取得
        $shops = $query->get();

        // 検索結果をビューに渡して表示
        return view('index', ['shops' => $shops]);
    }

    public function showDetail($id){
        $shop = Shop::find($id);
        $userId = auth()->id();
        $user = User::find($userId);

        $review = Review::where('user_id', $userId)->where('shop_id', $shop->id)->first();

        return view('detail', compact('shop', 'user', 'review'));
    }

    public function showReview($id) {
        $shop = Shop::find($id);
        $userId = auth()->id();
        $user = User::find($userId);

        return view('review', compact('shop', 'user'));
    }

    public function sort(Request $request){
        $sortType = $request->input('sort__type');

        $query = Shop::query()
            // ->withCount(['reviews as average_rating' => function ($query){
            //     $query->select(DB::raw('coalesce(avg(rating), 0)'));
            ->withCount(['reviews as average_rating' => function ($query) {
                $query->select(DB::raw('avg(rating)'));
            }]);

        switch ($sortType) {
            case 'random':
                $query->inRandomOrder();
                break;

            case 'rating_asc':
                $query->orderbyDesc('average_rating')->orderBy('id');
                break;

            case 'rating_desc':
                $query->orderByRaw('average_rating IS NULL')
                    ->orderBy('average_rating')
                    ->orderBy('id');
                break;

            default:
                $query->orderBy('id');
                break;
        }

        $shops = $query->get();

        return view('index', compact('shops', 'sortType'));
    }

    // public function importCsv(ImportCsvRequest $request)
    // {

    //     $file = $request->file('csv_file');

    //     $filePath = $file->getRealPath();

    //     $csvData = array_map('str_getcsv', file($filePath));

    //     // CSVのヘッダーを取り除く
    //     $header = array_shift($csvData);
    //     $errors = [];

    //     foreach ($csvData as $index => $row) {
    //         $data = array_combine($header, $row);

    //         // 各行のデータを個別にバリデーション
    //         $validator = \Validator::make($data, $request->rules(), $request->messages());
    //         if ($validator->fails()) {
    //             $errors[$index + 1] = $validator->errors()->all();
    //             continue;
    //         }

    //         // データベースに保存
    //         Shop::create([
    //             'user_id' => $data['ユーザーID'],
    //             'name' => $data['店舗名'],
    //             'area' => $data['地域'],
    //             'genre' => $data['ジャンル'],
    //             'detail' => $data['店舗概要'],
    //             'image_path' => $data['画像URL'],
    //         ]);
    //     }

    //     if (!empty($errors)) {
    //         return redirect()->back()->withErrors(['csv_errors' => $errors])->withInput();
    //     }

    //     return redirect()->route('shop.import.form')->with('success', 'CSVのインポートが完了しました。');
    // }

    public function showImportForm()
    {
        return view ('import');
    }

    // public function importCsv(ImportCsvRequest $request)
    // {
    //     $file = $request->file('csv_file');

    //     // ファイルをShift-JISからUTF-8に変換しつつ読み込む
    //     $filePath = $file->getRealPath();
    //     $fileContents = file_get_contents($filePath);  // ファイル全体を読み込む

    //     // Shift-JIS -> UTF-8に変換
    //     $fileContents = mb_convert_encoding($fileContents, 'UTF-8', 'SJIS-win');

    //     // 改行コードで分割（\n または \r\n）
    //     $lines = preg_split('/\r\n|\n/', $fileContents);

    //     // 空行を除去
    //     $lines = array_filter($lines, fn($line) => !empty(trim($line)));

    //     // CSVデータを正しく分割 (タブ区切りを指定)
    //     $csvData = array_map(function($line) {
    //         return str_getcsv($line, ","); // カンマ区切りとして処理
    //     }, $lines);
    //     // dd($csvData);

    //     // ヘッダー行とデータ行を分ける
    //     $header = array_shift($csvData); // 最初の行をヘッダーとして取得

    //     // データを処理
    //     $errors = [];
    //     foreach ($csvData as $index => $row) {
    //         $data = array_combine($header, $row);

    //     try {
    //         // データベースに保存
    //         Shop::create([
    //             'user_id' => $data['user_id'],
    //             'name' => $data['name'],
    //             'area' => $data['area'],
    //             'genre' => $data['genre'],
    //             'detail' => $data['detail'],
    //             'image_path' => $data['image_path'], // 保存した画像パスを格納
    //         ]);
    //         } catch (\Exception $e) {
    //             $errors[$index + 1][] = 'データの保存に失敗しました: ' . $e->getMessage();
    //         }
    //     }

    //     if (!empty($errors)) {
    //         return redirect()->back()->withErrors(['csv_errors' => $errors])->withInput();
    //     }

    //     return redirect()->route('show.import.form')->with('success', 'CSVのインポートが完了しました。');
    // }

    public function uploadImage(ImageUploadRequest $request)
    {
        $image = $request->file('image');

        $path = Storage::disk('public')->putFile('images', $image);

        $fileName = basename($path);

        return back()->with('success','画像情報を保存しました')->with('fileName', $fileName);
    }

    public function importCsv(Request $request)
    {
        $file = $request->file('csv_file');

        // ファイルをShift-JISからUTF-8に変換して読み込む
        $filePath = $file->getRealPath();
        $fileContents = file_get_contents($filePath);
        $fileContents = mb_convert_encoding($fileContents, 'UTF-8', 'SJIS-win');

        // 改行コードで分割
        $lines = preg_split('/\r\n|\n/', $fileContents);
        $lines = array_filter($lines, fn($line) => !empty(trim($line)));

        // CSVデータを配列に変換
        // $csvData = array_map(function($line) {
        //     return str_getcsv($line, ",");
        // }, $lines);
        $csvData = array_map(fn($line) => str_getcsv($line, ","), $lines);

        // ヘッダー行とデータ行を分ける
        $header = array_shift($csvData);

        $headerMapping = [
            'ユーザーID' => 'user_id',
            '店舗名' => 'name',
            'エリア' => 'area',
            'ジャンル' => 'genre',
            '店舗情報' => 'detail',
            '画像ファイル名' => 'image_path',
        ];

        $errors = [];
        foreach ($csvData as $index => $row) {
            // $data = array_combine($header, $row);
            $mappedData = [];
            foreach ($header as $key => $columnName) {
                if (isset($headerMapping[$columnName])) {
                    $mappedData[$headerMapping[$columnName]] = $row[$key];
                }
            }

            // 行データにバリデーションを適用
            $validator = \Validator::make($mappedData, [
                'user_id' => 'required',
                'name' => 'required|string|max:50',
                'area' => 'required|in:東京都,大阪府,福岡県',
                'genre' => 'required|in:寿司,焼肉,イタリアン,居酒屋,ラーメン',
                'detail' => 'required|string|max:400',
                'image_path' => ['required', 'regex:/.(jpeg|jpg|png)$/'],
            ], [
                'user_id.required' => 'ユーザーIDは必須項目です。',
                'name.required' => '店舗名は必須項目です。',
                'name.max' => '店舗名は50文字以内で入力してください。',
                'area.required' => 'エリアは必須項目です。',
                'area.in' => 'エリアは「東京都」「大阪府」「福岡県」のいずれかを指定してください。',
                'genre.required' => 'ジャンルは必須項目です。',
                'genre.in' => 'ジャンルは「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれかを指定してください。',
                'detail.required' => '店舗情報は必須項目です。',
                'detail.max' => '店舗情報は400文字以内で入力してください。',
                'image_path.required' => '画像ファイル名は必須項目です。',
                'image_path.regex' => '画像ファイル名はjpeg、jpgまたはpng形式のURLを指定してください。',
            ], [
                'attributes' => [
                    'user_id' => 'ユーザーID',
                    'name' => '店舗名',
                    'area' => 'エリア',
                    'genre' => 'ジャンル',
                    'detail' => '店舗情報',
                    'image_path' => '画像ファイル名',
                ],
            ]);

            if ($validator->fails()) {
                // エラーがある場合、エラーメッセージを収集
                $errors[$index + 2] = $validator->errors()->all();
                continue;
            }

            Shop::create($mappedData);
        }

        if (!empty($errors)) {
            // エラーメッセージを整形して出力
            $formattedErrors = [];
            foreach ($errors as $line => $lineErrors) {
                $formattedErrors[] = "行 {$line}：" . implode(' / ', $lineErrors);
            }


            return redirect()->back()->withErrors(['csv_errors' => $formattedErrors])->withInput();
        }
        //     return redirect()->back()->withErrors(['csv_errors' => $errors])->withInput();
        // }


        return redirect()->route('show.import.form')->with('success', 'CSVのインポートが完了しました。');
    }
}




