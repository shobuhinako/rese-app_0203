<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
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
}
