<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Review;
use App\Models\User;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Http\Requests\ReviewRequest;

class ReviewController extends Controller
{
    public function showReview($id)
    {
        $shop = Shop::find($id);
        $userId = auth()->id();
        $user = User::find($userId);

        $review = Review::where('user_id', $userId)->where('shop_id', $shop->id)->first();

        $area = $shop->area->area;
        $genre = $shop->genre->genre;

        return view('review', compact('shop', 'user', 'review', 'area', 'genre'));
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

        if ($review->image_path) {
            Storage::disk('public')->delete('images/' . $review->image_path);
        }

        $review->delete();

        return redirect()->route('shop_detail', $shop_id);
    }

    public function showShopReviews($shop_id)
    {
        $reviews = Review::where('shop_id', $shop_id)->get();
        return view('display-reviews', compact('reviews'));
    }

    public function deleteReview(Request $request)
    {
        $userId = $request->input('user_id');
        $shopId = $request->input('shop_id');

        $review = Review::where('user_id', $userId)->where('shop_id', $shopId)->first();

        if ($review->image_path) {
            Storage::disk('public')->delete('images/' . $review->image_path);
        }

        $review->delete();

        return redirect()->back()->with('success', '口コミが削除されました');
    }
}
