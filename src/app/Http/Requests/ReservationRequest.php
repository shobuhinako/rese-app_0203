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
    // public function rules()
    // {
    //     $user = Auth::user();

    //     return [

    //         'user_id' => 'required',
    //         'shop_id' => 'required',
    //         'reservation_date' => [
    //             'required',
    //             'date',
    //             'after_or_equal:today',

    //             Rule::unique('reservations')->where(function ($query) use ($user) {
    //                 // return $query->where('shop_id', $this->input('shop_id'))
    //                 return $query->where('reservation_date', $this->input('reservation_date'))
    //                     ->where('reservation_time', $this->input('reservation_time'))
    //                     ->where('user_id', $user->id);
    //             }),

    //             function ($attribute, $value, $fail) {
    //             $reservationDateTime = $this->input('reservation_date') . ' ' . $this->input('reservation_time');
    //             if (strtotime($reservationDateTime) <= time()) {
    //                 $fail('過去の時間は予約できません。');
    //             }
    //             }
    //         ],
    //         'reservation_time' => 'required',
    //         'number_of_people' => 'required',
    //     ];
    // }

    // public function messages()
    // {
    //     return [
    //         'reservation_date.unique' => 'その日時の予約は既に存在します。別の日時を選択してください。',
    //         'reservation_date.after_or_equal' => '過去の日付は選択できません。',
    //         // 'reservation_date.unique' => '同じお店は1日1回のみ予約できます。',
    //         'reservation_date.custom' => '過去の時間は予約できません。',
    //         'reservation_date.required' => '予約日を選択してください'
    //     ];
    // }

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

                // Rule::unique('reservations')->where(function ($query) use ($auth) {
                //     return $query->where('shop_id', $this->input('shop_id'))
                //         ->whereDate('reservation_date', now())
                //         ->where('user_id', $auth);
                // }),
            ],

            'reservation_time' => [
                'required',
                function ($attribute, $value, $fail) {
                    $reservationDateTime = $this->input('reservation_date') . ' ' . $this->input('reservation_time');
                    if (strtotime($reservationDateTime) <= time()) {
                        $fail('過去の時間は予約できません。');
                    }
                },
                Rule::unique('reservations')->where(function ($query) use ($auth) {
                        return $query->where('reservation_date', $this->input('reservation_date'))
                        ->where('reservation_time', $this->input('reservation_time'))
                        ->where('user_id', $auth);
                }),
            ],

            'number_of_people' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'reservation_date.unique' => 'その時間の予約は既に存在します。別の時間を選択してください。',
            'reservation_date.after_or_equal' => '過去の日付は選択できません。',
            // 'shop_id.unique' => '同じお店は1日1回のみ予約できます。',
            'reservation_date.custom' => '過去の時間は予約できません。',
            'reservation_date.required' => '予約日を選択してください'
        ];
    }
}
