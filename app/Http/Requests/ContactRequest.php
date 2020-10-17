<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\space;

class ContactRequest extends FormRequest
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
            'email' => 'required | email:strict,dns,spoof',
            'subject' => 'required | max:50',
            'inquiry' => 'required | max:1000',
        ];
    }

    public function messages()
    {
        return [
            'name.max' => '* 50文字以内で入力してください',
            'email.email' => '* 有効なメールアドレスを入力してください',
            'subject.max' => '* 50文字以内で入力してください',
            'inquiry.max' => '* 1000文字以内で入力してください',
        ];
    }
}
