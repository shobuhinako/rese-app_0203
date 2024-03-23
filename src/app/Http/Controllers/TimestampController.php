<?php

namespace App\Http\Controllers;
use App\Models\Timestamp;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\User;

class TimestampController extends Controller
{
    public function punchIn()
    {
        $user = Auth::user();

        $timestamp = Timestamp::create([
            'user_id' => $user->id,
            'punchIn' => Carbon::now(),
        ]);

        return redirect('/');
    }

    public function punchOut()
    {
        $user = Auth::user();
        $now = now();
        $timestamp = Timestamp::where('user_id', $user->id)
            ->whereDate('punchIn', $now->toDateString())
            ->first();
        
        if ($timestamp) {
        $timestamp->punchOut = $now;
        $timestamp->save();
        }

        return redirect('/');
    }
}
