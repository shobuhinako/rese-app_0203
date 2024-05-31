<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function showStatus($id){
        // $url = route('reservation.status', ['id' => $shop->id]);
        $shop = Shop::find($id);

        $currentDateTime = Carbon::now();
        $currentDate = $currentDateTime->format('Y-m-d');

        // $reservations = Reservation::where('shop_id', $id)->get();

        // $reservations = Reservation::where('shop_id', $id)
        //     ->where('reservation_date', '>', $currentDateTime->format('Y-m-d'))
        //     ->orWhere(function($query) use ($id, $currentDateTime) {
        //     $query->where('shop_id', $id)
        //     ->where('reservation_date', '=', $currentDateTime->format('Y-m-d'))
        //     ->where('reservation_time', '>', $currentDateTime->format('H:i:s'));
        //     })
        //     ->get();

        $reservations = Reservation::where('shop_id', $id)
            ->where('reservation_date', '=', $currentDate)
            ->get();

        return view('reservation-status', compact('shop', 'reservations'));
    }
}
