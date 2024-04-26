<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthController extends Controller
{

    public function register()
    {
        return view('/auth/register');
    }

    public function login()
    {
        return view('/auth/login');
    }

    /**
 * ユーザーをアプリケーションからログアウトさせる
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/auth/login');
    }

    public function create(Request $request)
    {
        $form = $request->only('name', 'email', 'password');
        $user = User::create([
            'name' => $form['name'],
            'email' => $form['email'],
            'password' => bcrypt($form['password']),
        ]);

        return redirect('/thanks');
    }


    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function index()
    {
        $shops = Shop::all();

        return view('index', ['shops' => $shops]);
    }

    public function mypage()
    {
        $auth = auth()->user()->id;

    // ログインユーザーが予約した店舗の情報を取得
    $reservationShops = Shop::whereIn('id', function ($query) use ($auth) {
        $query->select('shop_id')
            ->from('reservations')
            ->where('user_id', $auth);
    })->get();

    $reservationContents = Reservation::where('user_id', $auth)->get()->map(function ($reservation) {
    $reservation->formatted_reservation_time = Carbon::parse($reservation->reservation_time)->format('H:i');
    return $reservation;
    });


    // ログインユーザーがお気に入りに登録した店舗の情報を取得
    $favoriteShops = Shop::whereIn('id', function ($query) use ($auth) {
        $query->select('shop_id')
            ->from('favorites')
            ->where('user_id', $auth);
    })->get();

    // ログインユーザー情報を取得
    $user = User::find($auth);

    return view('mypage', compact('user', 'favoriteShops', 'reservationShops', 'reservationContents'));
    }
}
