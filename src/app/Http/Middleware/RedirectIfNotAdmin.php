<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAdmin
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            // staffでログインしている場合はstaffをログアウト
            if (Auth::guard('staff')->check()) {
                Auth::guard('staff')->logout();
            }
            return redirect('/admin/login');
        }
        return $next($request);
    }
}
