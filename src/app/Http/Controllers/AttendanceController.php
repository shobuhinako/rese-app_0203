<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function register()
    {
        return view('register');
    }

    public function login()
    {
        return view('login');
    }

    public function attendance()
    {
        return view('attendance');
    }

    public function index()
    {
        return view('index');
    }
}
