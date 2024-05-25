<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ShopCreateController extends Controller
{
    public function showCreateStorePage(){
        $imageFiles = Storage::disk('public')->files('images');
        $images = [];
        foreach ($imageFiles as $file) {
        $images[] = 'storage/app/public/' . $file;
        }

        $userId = Auth::id();

        return view ('create-shop', ['images' => $images, 'user_id' => $userId]);
    }

    // public function showCreateStorePage(){
    //     $imageFiles = Storage::disk('public')->files('images');
    //     $images = [];
    //     foreach ($imageFiles as $file) {
    //     $images[] = 'public/storage/' . $file;
    //     }
        
    //     return view ('create-shop', ['images' => $images]);
    // }

    // public function createShop()
    // {
    // // storage/app/public/imagesディレクトリ内の画像ファイルを取得する
    // $images = Storage::files('public/images');

    // return view('create-shop', compact('images'));
    // }

    public function createStore(Request $request)
    {
        $form = $request->only('user_id', 'name', 'area', 'genre', 'detail', 'image_path');

        $relativeImagePath = ltrim(str_replace(asset('storage/'), '', $form['image_path']), '/');

        $shop = Shop::create([
            'user_id' => $form['user_id'],
            'name' => $form['name'],
            'area' => $form['area'],
            'genre' => $form['genre'],
            'detail' => $form['detail'],
            'image_path' => $relativeImagePath,
        ]);

        session()->flash('success_message', '店舗を作成しました');

        return redirect('/create/shop');
    }

}
