<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotStaff
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('staff')->check()) {
            // adminでログインしている場合はadminをログアウトし、セッション全体をクリア
            if (Auth::guard('admin')->check()) {
                Auth::guard('admin')->logout();
                session()->flush();
                session()->regenerate();
                return redirect('/login');
            }
            return redirect('/login');
        }
        return $next($request);
    }
}
