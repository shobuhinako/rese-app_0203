<?php

namespace App\Http\Controllers;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\Shop;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class ManagerController extends Controller
{
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
}
