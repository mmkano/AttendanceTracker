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
                'password' => 'required|confirmed',
                'password_confirmation' => 'required_with:password|same:password',
            ];
    }

    public function messages()
    {
        return [
            'name.required' => 'お名前を入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスは「ユーザー名@ドメイン」形式で入力してください',
            'password.required' => 'パスワードを入力してください',
            'password.confirmed' => 'パスワードが一致しません',
            'password_confirmation.required_with' => '確認用パスワードを入力してください',
            'password_confirmation.same' => '確認用パスワードが一致しません',
        ];
    }
}
