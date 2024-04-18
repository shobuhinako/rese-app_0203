<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class SearchController extends Controller
{
    // public function search(Request $request)
    // {
    //     $area = $request->input('area');
    //     $genre = $request->input('genre');
    //     $text = $request->input('text');

    //     // ロジック: 検索クエリを使用して該当するお店を取得する

    //     return redirect('/');
    // }

    // public function search(Request $request)
    // {
    // // 検索条件を取得
    // $area = $request->input('area');
    // $genre = $request->input('genre');
    // $text = $request->input('name');

    // // // エリアが指定されている場合は、そのエリアの店舗のみを取得
    // if ($area !== 'all') {
    //     $query->where('area', $area);
    // }

    // // // ジャンルが指定されている場合は、そのジャンルの店舗のみを取得
    // if ($genre !== 'all') {
    //     $query->where('genre', $genre);
    // }

    // // // テキスト検索が指定されている場合は、店舗名がそのテキストを含む店舗を取得
    // if (!empty($text)) {
    //     $query->where('name', 'like', "%$text%");


    // // 店舗を取得
    // $shops = $query->get();

    // // 検索結果をビューに渡して表示
    // return view('index', ['shops' => $shops]);
    // }
    // }

//     public function search(Request $request)
//     {
//     // セレクトボックスで選択された値を取得
//     $selectedArea = $request->input('area');
//     $selectedGenre = $request->input('genre');

//     // テキストボックスで入力された店舗名を取得
//     $shopName = $request->input('name');

//     // クエリビルダーを使用してデータベースからデータを取得
//     $query = Shop::query();

//     // エリアが "All" ではない場合は、そのエリアのみを取得
//     if ($selectedArea !== 'All area') {
//         $query->where('area', $selectedArea);
//     }

//     // ジャンルが "All" ではない場合は、そのジャンルのみを取得
//     if ($selectedGenre !== 'All genre') {
//         $query->where('genre', $selectedGenre);
//     }

//     // テキストボックスに店舗名が入力されている場合は、その店舗名と一致するものを取得
//     if (!empty($shopName)) {
//         $query->where('name', 'like', "%$shopName%");
//     }

//     // データを取得
//     $shops = $query->get();

//     // ビューにデータを渡す
//     return view('index', ['shops' => $shops]);
// }

    // public function search(Request $request)
    // {
    // // フォームから送信されたデータを取得
    // $area = $request->input('area');
    // $genre = $request->input('genre');
    // $name = $request->input('name'); // テキストボックスから送信されたお店の名前

    // // エリアが "all" でない場合は、そのエリアの店舗のみを取得
    // if ($area !== 'all') {
    //     $shops = Shop::getByArea($area);
    // } else {
    //     // エリアが "all" の場合はすべての店舗を取得
    //     $shops = Shop::all();
    // }

    // // ジャンルが "all" の場合は、すべてのジャンルの店舗を取得
    // if ($genre === 'all') {
    //     $shops = $shops->merge(Shop::all());
    // } else {
    //     // ジャンルが "all" でない場合は、そのジャンルの店舗のみを取得
    //     $shops = $shops->merge(Shop::getByGenre($genre));
    // }

    // // テキストボックスに店舗名が入力されている場合は、店舗名がそのテキストを含む店舗を取得
    // if (!empty($name)) {
    //     $shops = $shops->merge(Shop::searchByName($name));
    // }

    // // 検索結果をビューに渡して表示
    // return view('index', ['shops' => $shops]);
    // }

    // public function find()
    // {
    // return view('index');
    // }

//     public function search(Request $request)
//     {
//     $areaMapping = [
//     'tokyo' => '東京都',
//     'osaka' => '大阪府',
//     'fukuoka' => '福岡県',
//     // 'all' => ['東京都', '大阪府', '福岡県'],
// ];

// $genreMapping = [
//     'sushi' => '寿司',
//     'italian' => 'イタリアン',
//     'ramen' => 'ラーメン',
//     'izakaya' => '居酒屋',
//     'yakiniku' => '焼肉',
//     // 'all' => ['寿司', 'イタリアン', 'ラーメン', '居酒屋', '焼肉'],
// ];

// // エリアとジャンルをマッピング
// $area = $areaMapping[$request->input('area')];
// $genre = $genreMapping[$request->input('genre')];
//     $name = $request->input('name'); // テキストボックスから送信されたお店の名前
// // dd($request->all());

//     // クエリビルダーを使用して、検索条件に基づいて店舗を取得
//     $query = Shop::query();

//     switch (true) {
//         case (!empty($area) && !empty($genre) && !empty($name)):
//             // エリア、ジャンル、店舗名がすべて指定されている場合
//             $query->where('area', $area)->where('genre', $genre)->where('name', 'like', "%$name%");
//             break;

//         case (!empty($area) && !empty($genre)):
//             // エリアとジャンルが指定されている場合
//             $query->where('area', $area)->where('genre', $genre);
//             break;

//         case (!empty($area) && !empty($name)):
//             // エリアと店舗名が指定されている場合
//             $query->where('area', $area)->where('name', 'like', "%$name%");
//             break;

//         case (!empty($area) && $area !== 'all' && $genre === 'all'):
//             // エリアが指定されていて、ジャンルが全ての場合
//             $query->whereIn('area', $areaMapping[$area])->whereIn('genre', $genreMapping['all']);
//             break;

//         case (!empty($genre) && !empty($name)):
//             // ジャンルと店舗名が指定されている場合
//             $query->where('genre', $genre)->where('name', 'like', "%$name%");
//             break;

//         case (!empty($genre) && $genre !== 'all' && $area === 'all'):
//             // ジャンルが指定されていて、エリアが全ての場合
//             $query->whereIn('genre', $genreMapping[$genre])->whereIn('area', $areaMapping['all']);
//             break;

//         case (!empty($name)):
//             // 店舗名が指定されている場合
//             $query->where('name', 'like', "%$name%");
//             break;

//         default:
//             // 条件が指定されていない場合はすべての店舗を取得
//             $query->whereNotNull('id');
//             break;
//     }

//     // 店舗を取得
//     $shops = $query->get();

//     // 検索結果をビューに渡して表示
//     return view('index', ['shops' => $shops]);
//     }

//     public function find()
//     {
//     return view('index');
//     }

public function search(Request $request)
{
    $areaMapping = array(
        'tokyo' => '東京都',
        'osaka' => '大阪府',
        'fukuoka' => '福岡県',
    // //     // 'all' => ['東京都', '大阪府','福岡県']
    );

    $genreMapping = [
        'sushi' => '寿司',
        'italian' => 'イタリアン',
        'ramen' => 'ラーメン',
        'izakaya' => '居酒屋',
        'yakiniku' => '焼肉',
        //'all' => ['寿司', 'イタリアン', 'ラーメン', '居酒屋', '焼肉'],
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


}
