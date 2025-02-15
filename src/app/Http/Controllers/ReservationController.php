<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;
use Carbon\Carbon;
use App\Http\Requests\ReservationRequest;
use App\Http\Requests\ChangeReservationRequest;

class ReservationController extends Controller
{
    public function showStatus($id){
        $shop = Shop::find($id);

        $currentDateTime = Carbon::now();
        $currentDate = $currentDateTime->format('Y-m-d');

        $reservations = Reservation::where('shop_id', $id)
            ->where('reservation_date', '=', $currentDate)
            ->orderBy('reservation_time')
            ->get();

        return view('reservation-status', compact('shop', 'reservations'));
    }

    public function reservation(ReservationRequest $request){
        $reservation = Reservation::create([
            'user_id' => $request->user_id,
            'shop_id' => $request->shop_id,
            'reservation_date' => $request->reservation_date,
            'reservation_time' => $request->reservation_time,
            'number_of_people' => $request->number_of_people,
        ]);

        $previousUrl = $request->session()->get('previous_url');

        return view ('done', compact('previousUrl'));
    }

    public function remove($id)
    {
        $reservation = Reservation::find($id);

        $reservation->delete();
        return redirect()->back();
    }

    public function edit($id, $shop_name)
    {
        $startHour = 10;
        $endHour = 21;

        // 時間の選択肢の配列の初期化
        $timeOptions = [];

        for ($hour = $startHour; $hour <= $endHour; $hour++) {
        // 各時間の30分前を追加します
        $timeOptions[] = sprintf('%02d:00:00', $hour); // 例: '10:00', '11:00', ...
        if ($hour < $endHour) {
        $timeOptions[] = sprintf('%02d:30:00', $hour); // 例: '10:30', '11:30', ...
        }
        }

        // 人数の選択肢の配列の初期化
        $numberOfPeopleOptions = [];
        for ($i = 1; $i <= 10; $i++) {
        $numberOfPeopleOptions[] = $i . '人';
        }

        $reservationContent = Reservation::find($id);

        // // 予約された時間が選択肢の中にあるかどうかをチェックして、あればそれを選択されたものにする
        $selectedTime = \Carbon\Carbon::parse($reservationContent->reservation_time);

        $timeOptions[] = $selectedTime->format('H:i');

        return view ('/reservation_change', compact('id', 'shop_name', 'reservationContent', 'timeOptions', 'numberOfPeopleOptions', 'selectedTime'));
    }

    public function update(ChangeReservationRequest $request, $id)
    {
        $form = $request->all();
        unset($form['_token']);
        Reservation::find($id)->update($form);
        return redirect('/mypage');
    }
}
