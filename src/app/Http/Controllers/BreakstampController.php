<?php

namespace App\Http\Controllers;

use App\Models\Timestamp;
use Illuminate\Http\Request;
use App\Models\Breakstamp;
use Auth;
use Carbon\Carbon;
use App\User;

class BreakstampController extends Controller
{
    public function breakIn()
    {
        $user = Auth::user();
        $todayTimestamp = Timestamp::where('user_id', $user->id)
        ->whereDate('created_at', now()->toDateString())
        ->first();

        if($todayTimestamp) {
            $breakstamp = Breakstamp::create([
                'timestamp_id' => $todayTimestamp->id,
                'breakIn' => now(),
            ]);

        return redirect('/');
        }
    }

    public function breakOut()
    {
        $user = Auth::user();

        // 休憩開始が入っていて、かつ休憩終了が入っていないレコードを取得する
        $breakstampToUpdate = Breakstamp::whereHas('timestamp', function ($query) use ($user) {
        $query->where('user_id', $user->id)
              ->whereNotNull('breakIn') // 休憩開始が入っている
              ->whereNull('breakOut'); // 休憩終了が入っていない
        })->first();

        // レコードが取得された場合は、休憩終了のデータを更新する
        if ($breakstampToUpdate) {
            $breakstampToUpdate->breakOut = now();
            $breakstampToUpdate->save();
        }

        return redirect('/');
    }
}