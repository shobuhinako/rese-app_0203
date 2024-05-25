<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendEmail;
use App\Mail\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendNotificationController extends Controller
{
    public function showNotification(){
        return view('send-notification');
    }

    public function sendNotification(Request $request) {
    $destination = $request->input('destination');
    $message = $request->input('message');

    $users = collect();

    if ($destination === 'all') {
        $users = User::all();
    } elseif ($destination === 'user') {
        #rolesを持っていないuserを取得
        $users = User::whereNull('role_id')->get();
    }

    foreach ($users as $user) {
        Mail::to($user->email)->send(new SendEmail($user, $message));
    }

    return back()->with('success', 'お知らせを送信しました');
    }
}
