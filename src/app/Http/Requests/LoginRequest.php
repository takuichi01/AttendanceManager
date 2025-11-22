<?php
namespace App\Http\Requests;

use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;

class LoginRequest extends FortifyLoginRequest
{
    public function rules()
    {
        // ここでバリデーションルールを自由に変更
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'メールアドレスを入力してください',
            //'email.email' => 'メールアドレスの形式が正しくありません。',
            'password.required' => 'パスワードを入力してください',
        ];
    }
}
