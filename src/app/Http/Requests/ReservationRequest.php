<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Reservation;

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
        // return [
        //     'user_id' => 'required',
        //     'shop_id' => 'required',
        //     'reservation_date' => [
        //         'required',
        //         'date',
                
        //         function ($attribute, $value, $fail) {
        //             if (strtotime($value) < strtotime('today')) {
        //                 $fail('過去の日付は選択できません');
        //             }
        //         },

        //         Rule::unique('reservations')->where(function ($query) {
        //             return $query->where('shop_id', $this->shop_id)
        //                 ->where('reservation_date', $this->reservation_date);
        //         })
        //     ],
        //     'reservation_time' => [

        //     'required',
        //     function ($attribute, $value, $fail) {
        //         $reservationDateTime = $this->input('reservation_date') . ' ' . $value;
        //         $existingReservation = Reservation::where('reservation_date', $this->input('reservation_date'))
        //             ->where('reservation_time', $value)
        //             ->where('shop_id', $this->input('shop_id'))
        //             ->exists();
                
        //         if ($existingReservation) {
        //             $fail('その日時の予約は既に存在します。別の日時を選択してください。');
        //         }
        //     },
        //     ]
        //     'number_of_people' => 'required'
        // ];

        return [
            'user_id' => 'required',
            'shop_id' => 'required',
            'reservation_date' => [
                'required',
                'date',
                'after_or_equal:today',
                Rule::unique('reservations')->where(function ($query) {
                    return $query->where('shop_id', $this->input('shop_id'))
                        ->where('reservation_date', $this->input('reservation_date'))
                        ->where('reservation_time', $this->input('reservation_time'));
                }),

                Rule::unique('reservations')->where(function ($query) {
                    return $query->where('shop_id', $this->input('shop_id'))
                        ->whereDate('reservation_date', now());
                }),

                function ($attribute, $value, $fail) {
                    $reservationDateTime = $this->input('reservation_date') . ' ' . $this->input('reservation_time');
                    if (strtotime($reservationDateTime) <= time()) {
                        $fail('過去の日時は予約できません。');
                    }
                },
            ],
            'reservation_time' => 'required',
            'number_of_people' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'reservation_date.unique' => 'その日時の予約は既に存在します。別の日時を選択してください。',
            'reservation_date.after_or_equal' => '過去の日付は選択できません。',
            'reservation_date.unique' => '同じお店は1日1回のみ予約できます。',
            'reservation_date.custom' => '過去の日時は予約できません。',
        ];
    }
}
