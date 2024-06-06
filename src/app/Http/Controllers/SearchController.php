<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class SearchController extends Controller
{
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
}
