<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'shop_id', 'reservation_date', 'reservation_time', 'number_of_people'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function shop() {
        return $this->belongsTo(Shop::class);
    }

    public static function checkExistingReservation($shopId, $date)
    {
        return Reservation::where('shop_id', $shopId)
            ->where('reservation_date', $date)
            ->exists();
    }
}
