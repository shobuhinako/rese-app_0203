<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Timestamp;
use App\Models\Breakstamp;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

class AuthController extends Controller
{

    public function index()
    {
        $auth=auth()->user()->id;
        $user=User::find($auth);
        $now = now()->toDateString();
        $punchin = Timestamp::whereDate('punchIn', $now)
        ->where('user_id', $user->id)
        ->first();

        $punchout = Timestamp::whereDate('punchOut', $now)
        ->where('user_id', $user->id)
        ->first();

        $breakinRecord = Breakstamp::whereHas('timestamp', function ($query) use ($user) {
        $query->where('user_id', $user->id);
        })->latest()->first();
        $breakin = $breakinRecord ? $breakinRecord->breakIn : null;

        $breakoutRecord = Breakstamp::whereHas('timestamp', function ($query) use ($user) {
        $query->where('user_id', $user->id);
        })->latest()->first();
        $breakout = $breakoutRecord ? $breakoutRecord->breakOut : null;

        return view ('index', compact('user', 'punchin', 'punchout', 'breakin','breakout'));
    }

    public function register()
    {
        return view('/auth/register');
    }

    public function login()
    {
        return view('/auth/login');
    }

    public function attendance($dt = null)
    {
    if ($dt === null) {
        $dt = Carbon::now()->format('Y-m-d');
    }

    // タイムスタンプを取得
    $timestamps = Timestamp::whereDate('created_at', $dt)->with('user')->paginate(5);

    foreach ($timestamps as $timestamp) {
        $timestamp->punchIn = Carbon::parse($timestamp->punchIn)->format('H:i:s');
        $timestamp->punchOut = Carbon::parse($timestamp->punchOut)->format('H:i:s');
        $timestamp->user_name = $timestamp->user->name ?? 'Unknown';

        // 休憩時間を計算
        $breakstamps = Breakstamp::where('timestamp_id', $timestamp->id)->get();
        $total_break_time = 0;
        if ($breakstamps->isNotEmpty()) {
            foreach ($breakstamps as $breakstamp) {
                $break_in = Carbon::parse($breakstamp->breakIn);
                $break_out = Carbon::parse($breakstamp->breakOut);
                $break_duration = $break_out->diff($break_in);
                $total_break_time += $break_duration->h * 3600 + $break_duration->i * 60 + $break_duration->s;
            }
        }
        $timestamp->total_break_time = gmdate('H:i:s', $total_break_time);

        $punchIn = Carbon::parse($timestamp->punchIn);
        $punchOut = Carbon::parse($timestamp->punchOut);
        $work_duration_seconds = $punchOut->diffInSeconds($punchIn) - $total_break_time;

        if ($work_duration_seconds < 0) {
        $work_duration_seconds = 0;
        }

        $hours = floor($work_duration_seconds / 3600);
        $minutes = floor(($work_duration_seconds % 3600) / 60);
        $seconds = $work_duration_seconds % 60;
        $timestamp->work_duration = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    return view('/attendance', ['dt' => $dt, 'timestamps' => $timestamps]);
    }

    public function adddate($dt)
    {
        $dt = Carbon::parse($dt)->addDay()->format('Y-m-d');
        return $this->attendance($dt);
    }

    public function subday($dt)
    {
        $dt = Carbon::parse($dt)->subDay()->format('Y-m-d');
        return $this->attendance($dt);
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
        $form = $request->all();
        User::create($form);
        return redirect('/register');
    }

}
