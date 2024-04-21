<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Shop;
use App\Models\Favorite;
use App\Models\Reservation;

class ShopController extends Controller
{
    public function showDetail($id)
    {
        $shop = Shop::find($id);
        $user = User::find($id);
        return view('detail', compact('shop', 'user'));
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
        // return redirect()->back()->with('isFavorite', $isFavorite);

        session()->put('isFavorite', $isFavorite);
        session()->put('favoriteShopId', $shop->id);
        }
        return redirect()->back();
    }

    // public function showReservation(Request $request) {
    // $selectedDate = $request->input('date');
    // $selectedTime = $request->input('time');
    // $selectedNumberOfPeople = $request->input('number of people');
    // return view('reservation', [
    //     'selectedDate' => $selectedDate,
    //     'selectedTime' => $selectedTime,
    //     'selectedNumberOfPeople' => $selectedNumberOfPeople,
    // ]);
    // }

    public function reservation(Request $request){
        $form = $request->all();
        // $shop = Shop::find($id);

        $reservation = Reservation::create([
            'user_id' => $form['user_id'],
            'shop_id' => $form['shop_id'],
            'reservation_date' => $form['reservation_date'],
            'reservation_time' => $form['reservation_time'],
            'number_of_people' => $form['number_of_people'],
        ]);

        $previousUrl = $request->session()->get('previous_url');

        // return view('done')->with('previous_page', $request->previous_page);
        // return view('done')->route('done', ['previous_page' => url()->current()]);
        //
        return view ('done', compact('previousUrl'));
    }

    // public function done(Request $request){

    // $shop_id = $shop->id;
    // // 元いたページのURLを取得
    // $previous_page = $request->session()->get('previous_page');

    // // 元いたページのURLが存在する場合は、そのページにリダイレクト
    // if ($previous_page) {
    //     return redirect($previous_page)->with('shop_id', $shop_id);
    // }

    // // 元いたページのURLが存在しない場合は、デフォルトのURLにリダイレクト
    // return redirect('/');
    // }

    // public function back(){
    //     return back()->withInput();
    // }

    // public function back(Request $request)
    // {

    // // ミドルウェアが保存してくれてるsessionからURLを取得する
    // $previousUrl = $request->session()->get('previous_url');
    // if ($previousUrl) {
    //     // セッションから前のURLを削除（次回のリクエストで同じURLにリダイレクトしないように）
    //     $request->session()->forget('previous_url');
    //     return redirect($previousUrl);
    // }
    // return redirect(route('shop_detail'));
    // }

}
