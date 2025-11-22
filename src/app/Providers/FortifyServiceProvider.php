<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Providers\RouteServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Contracts\LogoutResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // ログイン後のリダイレクト
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {
                $guard = auth()->guard('admin')->check() ? 'admin' : 'staff';
                $redirectTo = $guard === 'admin' 
                    ? RouteServiceProvider::ADMIN_HOME
                    : RouteServiceProvider::HOME;
                
                return redirect()->intended($redirectTo);
            }
        });

        // 登録後のリダイレクト（スタッフのみ）
        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
            public function toResponse($request)
            {
                return redirect(RouteServiceProvider::HOME);
            }
        });

        $this->app->singleton(LogoutResponse::class, function () {
            return new class implements LogoutResponse {
                public function toResponse($request)
                {
                    // 管理者なら /admin/login、スタッフなら /login へリダイレクト
                    if ($request->is('admin/*')) {
                        return redirect('/admin/login');
                    }
                    return redirect('/login');
                }
            };
        });
    }

    

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        
        // スタッフ登録画面
        Fortify::registerView(function () {
            return view('auth.register');
        });

        // ログイン画面（URLでガード判定）
        Fortify::loginView(function () {
            if (request()->is('admin/login')) {
                config(['fortify.guard' => 'admin']);
                return view('auth.admin_login');
            }
            return view('auth.user_login');
        });

        // ログイン認証時のガード切り替え
        Fortify::authenticateUsing(function (Request $request) {
            $guard = request()->is('admin/login') ? 'admin' : 'staff';
            config(['fortify.guard' => $guard]);
            
            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];
            
            if (auth()->guard($guard)->attempt($credentials, $request->boolean('remember'))) {
                return auth()->guard($guard)->user();
            }
            
            return null;
        });

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(10)->by($email . $request->ip());
        });

        $this->app->bind(\Laravel\Fortify\Http\Requests\LoginRequest::class, \App\Http\Requests\LoginRequest::class);
    }
}
