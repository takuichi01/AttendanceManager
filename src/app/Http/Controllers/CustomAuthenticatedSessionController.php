<?php
namespace App\Http\Controllers;

use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Requests\LoginRequest;

class CustomAuthenticatedSessionController extends AuthenticatedSessionController
{
    public function store(LoginRequest $request)
    {
        // ここでバリデーションは自作FormRequestのrules()が使われる
        return parent::store($request);
    }
}