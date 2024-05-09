<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Review;
use App\Models\Reservation;

class ReviewController extends Controller
{
    public function review($shop_name)
    {
        return view('review', ['shop_name' => $shop_name]);
    }

    public function createReview(Request $request){

        $user_id = auth()->id();

        $shop_id = session('shop_id');
        $reservation_id = session('reservation_id');

        $review = Review::create([
        'user_id' => $user_id,
        'shop_id' => $shop_id,
        'reservation_id' => $reservation_id,
        'point' => $request->point,
        'comment' => $request->comment,
        ]);

        // $previousUrl = $request->session()->get('previous_url');

        // return view ('done', compact('previousUrl'));

        return redirect ('/mypage');
    }
}
