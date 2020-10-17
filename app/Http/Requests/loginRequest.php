<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class loginRequest extends FormRequest
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
            'email' => 'required | string | email:strict,dns,spoof',
            'password' => 'required | string | min:8 | max:128',
        ];
    }

    public function messages()
    {
        return [
            'email.email' => '* 有効なメールアドレスを入力してください',
            'password.min' => '* 8文字以上で入力してください',
            'password.max' => '* 128文字以内で入力してください',
        ];
    }
}
