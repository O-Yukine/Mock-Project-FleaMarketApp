<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'profile_image' => 'nullable|file|mimetypes:image/jpeg,image/png',
            'name' => 'required|max:20',
            'post_code' => 'required|regex:/^\d{3}-\d{4}$/',
            'address'     => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'profile_image.mimetypes' => '拡張子は .jpeg または .png の画像のみ選択できます',
            'name.required' => 'ユーザー名を入力してください',
            'name.max' => '20文字以内で入力してください',
            'post_code.required' => '郵便番号を入力してください',
            'post_code.regex'    => '郵便番号の形式が正しくありません（例: 123-4567)',
            'address.required'     => '住所を入力してください',
        ];
    }
}
