<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Review;
use App\Models\User;
use App\Models\Shop;
use App\Http\Requests\ReviewRequest;

class ReviewController extends Controller
{
    public function showReview($id)
    {
        $shop = Shop::find($id);
        $userId = auth()->id();
        $user = User::find($userId);

        $review = Review::where('user_id', $userId)->where('shop_id', $shop->id)->first();

        return view('review', compact('shop', 'user', 'review'));
    }

    public function store(ReviewRequest $request)
    {
        $review = Review::where('shop_id', $request->shop_id)
                        ->where('user_id', Auth::id())
                        ->first();

        if (!$review) {
            $review = new Review();
            $review->shop_id = $request->shop_id;
            $review->user_id = Auth::id();
        }

        $review->rating = $request->rating;
        $review->comment = $request->comment;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images');
            $review->image_path = basename($path);
        }

        $review->save();

        return redirect()->route('shop_detail', $review->shop_id);
    }

    public function remove(Request $request, $shop_id)
    {
        $review = Review::where('shop_id', $request->shop_id)
                        ->where('user_id', Auth::id())
                        ->first();

        $review->delete();

        return redirect()->route('shop_detail', $shop_id);
    }
}
