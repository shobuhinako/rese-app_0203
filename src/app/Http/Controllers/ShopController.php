<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class ShopController extends Controller
{
    public function showDetail($id)
    {
    $shop = Shop::find($id);
    return view('detail', compact('shop'));
    }
}
