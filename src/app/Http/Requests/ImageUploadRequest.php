<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageUploadRequest extends FormRequest
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
            'image' => 'required|mimes:jpeg,jpg,png',
        ];
    }

    public function messages()
    {
        return [
            'image.required' => '画像は必須です。',
            'image.mimes' => '画像はjpeg, jpg, pngの形式でアップロードしてください。',
        ];
    }
}
