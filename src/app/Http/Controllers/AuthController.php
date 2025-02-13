<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Reservation;
use App\Models\Favorite;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Mail\VerifyEmail;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function showRegisterForm()
    {
        return view('/auth/register');
    }

    public function showLoginForm()
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
        return redirect('/login');
    }

    public function create(RegisterRequest $request)
    {
        $form = $request->only('name', 'email', 'password');
        $user = User::create([
            'name' => $form['name'],
            'email' => $form['email'],
            'password' => bcrypt($form['password']),
        ]);

        Mail::to($user->email)->send(new VerifyEmail($user));

        session()->flash('success_message', '本人確認メールを送信しました。');

        return redirect('/thanks');
    }


    public function login(LoginRequest $request):RedirectResponse
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            // ログイン成功時の処理
            $user = Auth::user();

            if ((new User)->where('email', $user->email)->whereNotNull('email_verified_at')->exists()) {
                // 本人確認が完了している場合
                $request->session()->regenerate();
                return redirect('/');
            } else {
                // 本人確認が未完了の場合
                Auth::logout();
                return back()->withErrors(['email' => '本人確認が完了していません。'])->onlyInput('email');
            }
        } else {
            // 認証失敗時の処理
            return back()->withErrors(['email' => '認証情報が正しくありません。'])->onlyInput('email');
        }
    }

    public function showThanks()
    {
        return view ('thanks');
    }

    protected function authenticated(Request $request, $user)
    {
        Session::put('lastActivityTime', time());
        return redirect()->intended($this->redirectPath());
    }


    public function index()
    {
        $shops = Shop::with(['area', 'genre'])->get();

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

        if ($reservationShops->isNotEmpty()) {
            session(['shop_id' => $reservationShops->first()->id]);
        }

        // ログインユーザーがお気に入りに登録した店舗の情報を取得
        $favoriteShops = Shop::whereIn('id', function ($query) use ($auth) {
            $query->select('shop_id')
                ->from('favorites')
                ->where('user_id', $auth);
        })->get();

        // ログインユーザー情報を取得
        $user = User::find($auth);

        $currentDateTime = Carbon::now();
        $currentDate = $currentDateTime->toDateString(); // 日付のみ取得
        $currentTime = $currentDateTime->toTimeString(); // 時間のみ取得

        $reservations = Auth::user()->reservations()
            ->where(function ($query) use ($currentDate, $currentTime) {
                $query->where('reservation_date', '>', $currentDate)
                      ->orWhere(function ($query) use ($currentDate, $currentTime){
                        $query->where('reservation_date', '=', $currentDate)
                              ->where('reservation_time', '>', $currentTime);
                      });
            })
            ->get();

        return view('mypage', compact('user', 'favoriteShops', 'reservationShops', 'currentDate', 'currentTime', 'reservations'));
    }

    public function adminPage(){
        $user = auth()->user();
        return view('admin-mypage', ['user' => $user]);
    }

    public function managerPage(){
        $user = auth()->user();
        $userId = Auth::id();

        $shops = Shop::where('user_id', $userId)->get();

        $tempReservations = [];
        foreach ($shops as $shop) {
            $shopReservations = Reservation::with('user')
                ->where('shop_id', $shop->id)
                ->where(function ($query) {
                    $query->where('reservation_date', '>', now()->toDateString()) // 今日以降の日付
                        ->orWhere(function ($query) {
                            $query->where('reservation_date', now()->toDateString())
                                  ->where('reservation_time', '>=', now()->format('H:i:s')); // 今の時刻以降の時間
                        });
            })
            ->orderBy('reservation_date')
            ->orderBy('reservation_time')
            ->get();

            foreach ($shopReservations as $reservation) {
            $tempReservations[$reservation->id] = $reservation;
            }
        }

        $reservations = collect($tempReservations);

        return view('manager-mypage', ['user' => $user], ['reservations' => $reservations]);
    }

    public function showAdmin(){
        return view ('create-admin');
    }

    public function createAdmin(RegisterRequest $request)
    {
        $form = $request->only('name', 'email', 'password');
        $user = User::create([
            'role_id' => 1,
            'name' => $form['name'],
            'email' => $form['email'],
            'password' => bcrypt($form['password']),
        ]);

        Mail::to($user->email)->send(new VerifyEmail($user));

        session()->flash('success_message', '本人確認メールを送信しました。');

        return redirect('/create/admin');
    }

    public function showManager(){
        $shops = Shop::all();
        return view ('create-manager', ['shops' => $shops]);
    }

    public function createManager(RegisterRequest $request)
    {
        $form = $request->only('shop_id', 'name', 'email', 'password');
        $user = User::create([
            'role_id' => 2,
            'name' => $form['name'],
            'email' => $form['email'],
            'password' => bcrypt($form['password']),
        ]);

        $shop = Shop::find($form['shop_id']);
        if ($shop) {
            $shop->user_id = $user->id;
            $shop->save();
        }

        Mail::to($user->email)->send(new VerifyEmail($user));

        session()->flash('success_message', '本人確認メールを送信しました。');

        return redirect('/create/manager');
    }

    public function verify(Request $request, $id, $hash)
    {
        // ユーザーを取得
        $user = User::findOrFail($id);

        // メールアドレスのハッシュを検証
        if (sha1($user->email) !== $hash) {
            abort(403);
        }

        // ユーザーのメールアドレスを認証済みに設定
        $user->markEmailAsVerified();

        // 本人確認完了メッセージとログインURLを含むビューを返す
        return view('emails.verification_complete');
    }
}
