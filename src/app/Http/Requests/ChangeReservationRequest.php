<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Reservation;
use Carbon\Carbon;

class ChangeReservationRequest extends FormRequest
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
            'reservation_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'reservation_time' => [
                'required',
                function ($attribute, $value, $fail) {
                    $selectedDateTime = Carbon::parse($this->reservation_date . ' ' . $value);
                    if ($selectedDateTime->lte(now())) {
                        $fail('過去の時間は予約できません');
                    }
                },
                Rule::unique('reservations')->where(function ($query) use ($auth){
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
            'reservation_time.custom' => '過去の時間は予約できません',
            'reservation_date.after_or_equal' => '過去の日付は予約できません',
            'reservation_time.unique' => 'その日時の予約は既に存在します。別の日時を選択してください。',
        ];
    }
}
