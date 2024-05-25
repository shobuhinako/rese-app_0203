<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ShopUpdateController extends Controller
{
    public function showUpdateStorePage(){

        $userId = Auth::id();
        $shops = Shop::where('user_id', $userId)->get();

        $imageFiles = Storage::disk('public')->files('images');
        $images = [];
        foreach ($imageFiles as $file) {
        $images[] = 'storage/app/public/' . $file;
        }

        $userId = Auth::id();

        return view ('update-shop', ['images' => $images, 'shops' => $shops]);
    }

    public function updateStore(Request $request)
    {
        $shopId = $request->input('name');
        $shop = Shop::findOrFail($shopId);

        $relativeImagePath = ltrim(str_replace(asset('storage/'), '', $request->input('image_path')), '/');

        $shop->update([
            'area' => $request->input('area'),
            'genre' => $request->input('genre'),
            'detail' => $request->input('detail'),
            'image_path' => $relativeImagePath,
        ]);

        session()->flash('success_message', '店舗情報を更新しました');

        return redirect('/update/shop');
    }
}
