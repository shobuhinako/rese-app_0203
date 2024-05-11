<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Review;
use App\Models\Reservation;

class ReviewController extends Controller
{
    public function review($reservation_id)
    {
        $reservation = Reservation::findOrFail($reservation_id);
        $shop_name = $reservation->shop->name;

        return view('review', ['reservation' => $reservation, 'shop_name' => $shop_name]);
    }


    public function createReview(Request $request){

        $user_id = auth()->id();
        $reservation_id = $request->input('reservation_id');

        $reservation = Reservation::findOrFail($reservation_id);
        $shop_id = $reservation->shop->id;

        $review = Review::create([
        'user_id' => $user_id,
        'shop_id' => $shop_id,
        'reservation_id' => $reservation_id,
        'point' => $request->point,
        'comment' => $request->comment,
        ]);

        return redirect ('/mypage');
    }
}
