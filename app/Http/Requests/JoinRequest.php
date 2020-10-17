<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\space;

class JoinRequest extends FormRequest
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
            'name' => 'required | space | max:50',
            'email' => 'required | unique:users,email| email:strict,dns,spoof',
            'password' => 'required | min:8 | max:128',
            'password_c' => 'required | same:password',
        ];
    }

    public function messages()
    {
        return [
            'name.max' => '* 50文字以内で入力してください',
            'email.unique' => '* このメールアドレスは既に使用されています',
            'email.email' => '* 有効なメールアドレスを入力してください',
            'password.min' => '* 8文字以上で入力してください',
            'password.max' => '* 128文字以内で入力してください',
            'password_c.same' => '* 同じパスワードを入力してください',
        ];
    }
}
