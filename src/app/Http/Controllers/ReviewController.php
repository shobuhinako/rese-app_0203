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

        return view('review', compact('shop', 'user'));
    }

    public function store(ReviewRequest $request)
    {
        $review = new Review();
        $review->shop_id = $request->shop_id;
        $review->user_id = Auth::id();
        $review->rating = $request->rating;
        $review->comment = $request->comment;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images');
            $review->image_path = basename($path);
        }

        $review->save();

        return redirect()->route('shop_detail', $review->shop_id);
    }
}
