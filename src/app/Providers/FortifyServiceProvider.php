<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // ユーザー作成処理（必須）
        $this->app->singleton(
            CreatesNewUsers::class,
            CreateNewUser::class
        );

        // 登録後のリダイレクト先変更
        $this->app->singleton(RegisterResponse::class, function () {
            return new class implements RegisterResponse {
                public function toResponse($request)
                {
                    return redirect('/register/step2');
                }
            };
        });

        $this->app->singleton(LoginResponse::class, function () {
            return new class implements LoginResponse {
                public function toResponse($request)
                {
                    return redirect('/weight_logs');
                }
            };
        });

        $this->app->singleton(LogoutResponse::class, function () {
            return new class implements LogoutResponse {
                public function toResponse($request)
                {
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
        //register画面
        Fortify::registerView(function () {
            return view('auth.register');
        });

        // login画面
        Fortify::loginView(function () {
            return view('auth.login');
        });

        RateLimiter::for('login', function ($request) {
            return Limit::perMinute(10); // ← 開発中
        });

        $this->app->singleton(LoginResponse::class, function () {
            return new class implements LoginResponse {
                public function toResponse($request)
                {
                    return redirect('/weight_logs');
                }
            };
        });

    }
}
