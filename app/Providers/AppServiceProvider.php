<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('registration', function (Request $request) {
            $email = strtolower(trim((string) $request->input('email')));

            return [
                Limit::perMinute(5)->by(
                    'registration:ip:' . $request->ip()
                ),

                Limit::perMinute(3)->by(
                    'registration:email:' . hash('sha256', $email)
                ),
            ];
        });

        RateLimiter::for('password-reset', function (Request $request) {
            return [
                Limit::perMinute(5)->by(
                    'password-reset:ip:' . $request->ip()
                ),
            ];
        });
    }
}