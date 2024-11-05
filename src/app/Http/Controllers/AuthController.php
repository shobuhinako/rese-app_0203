<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view ('/auth/register');
    }

    public function showLoginForm()
    {
        return view ('/auth/login');
    }

    public function create(Request $request)
    {
        $form = $request->only('name', 'email', 'password');
        $user = User::create([
            'name' => $form['name'],
            'email' => $form['email'],
            'password' => bcrypt($form['password']),
        ]);

        return redirect ('/login');
    }
}
