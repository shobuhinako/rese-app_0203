<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Shop;
use App\Models\Favorite;

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
}
