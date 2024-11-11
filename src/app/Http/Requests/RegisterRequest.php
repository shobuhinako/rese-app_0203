<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        return [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Usernameを入力してください',
            'email.required' => 'Emailを入力してください',
            'email.email' => 'Emailは「ユーザー名@ドメイン」形式で入力してください',
            'password.required' => 'Passwordを入力してください',
            'password.min' => 'Passwordは8文字以上で設定してください'
        ];
    }
}
