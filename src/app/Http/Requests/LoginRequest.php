<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\EmailVerified;

class LoginRequest extends FormRequest
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
            'email' => ['required', 'email', new EmailVerified($this->input('email'))],
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Emailを入力してください',
            'email.email' => '有効なメールアドレスを入力してください',
            'password.required' => 'Passwordを入力してください',
        ];
    }
}
