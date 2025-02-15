<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        $auth = auth()->user()->id;

        return [
            'user_id' => 'required',
            'shop_id' => 'required',
            'reservation_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'reservation_time' => [
                'required',
                function ($attribute, $value, $fail) use ($auth) {
                    $reservationDateTime = $this->input('reservation_date') . ' ' . $this->input('reservation_time');
                    if (strtotime($reservationDateTime) <= time()) {
                        $fail('過去の時間は予約できません');
                    }

                    $formattedDate = date('Y-m-d', strtotime($this->input('reservation_date')));
                    $formattedTime = date('H:i:s', strtotime($this->input('reservation_time')));

                    $exists = \DB::table('reservations')
                        ->where('reservation_date', $formattedDate)
                        ->where('reservation_time', $formattedTime)
                        ->where('user_id', $auth)
                        ->exists();

                    if ($exists) {
                        $fail('その時間の予約はすでに存在します。別の時間を選択してください。');
                    }
                }
            ],

            'number_of_people' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'reservation_date.after_or_equal' => '過去の日付は選択できません',
            'reservation_date.required' => '予約日を選択してください'
        ];
    }
}
