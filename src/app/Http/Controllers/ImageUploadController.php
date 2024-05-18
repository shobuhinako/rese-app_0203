<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        // バリデーションを行う
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        // 画像を取得
        $image = $request->file('image');

        // 画像をストレージに保存
        $path = Storage::disk('public')->putFile('images', $image);

        $url = Storage::disk('public')->url($path);

        // 画像情報をデータベースに保存
        $imageModel = new Image();
        $imageModel->image_path = $path;
        $imageModel->save();

        return back()->with('success','Image uploaded successfully');
    }

    public function showUploadForm()
    {
        return view('upload-form');
    }
}
