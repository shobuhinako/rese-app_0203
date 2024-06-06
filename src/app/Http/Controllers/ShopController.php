<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Shop;
use App\Models\Favorite;
use App\Models\Reservation;
use App\Http\Requests\ReservationRequest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ShopController extends Controller
{
    public function showDetail($id){
        $shop = Shop::find($id);
        $userId = auth()->id();
        $user = User::find($userId);

        // 店舗代表者の場合のみQRコードを生成
        $qrCode = null;
        if ($user && $user->role_id === 2 && $shop->isOwner($userId)) {
            $url = route('reservation.status', ['id' => $shop->id]);
            $qrCode = base64_encode(QrCode::format('png')->size(200)->generate($url));
        }

        return view('detail', compact('shop', 'user', 'qrCode'));
    }


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

    public function reservation(ReservationRequest $request){
        $reservation = Reservation::create([
        'user_id' => $request->user_id,
        'shop_id' => $request->shop_id,
        'reservation_date' => $request->reservation_date,
        'reservation_time' => $request->reservation_time,
        'number_of_people' => $request->number_of_people,
        ]);

        $previousUrl = $request->session()->get('previous_url');

        return view ('done', compact('previousUrl'));
    }

    public function remove(Request $request)
    {
        Reservation::find($request->id)->delete();
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
}
