<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // 1. Login — 5 attempts per minute per IP
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)
                ->by($request->ip())
                ->response(function () {
                    return back()->withErrors([
                        'email' => 'Too many login attempts. Please wait a minute and try again.',
                    ]);
                });
        });

        // 2. Registration — 10 attempts per minute per IP
        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinute(10)
                ->by($request->ip())
                ->response(function () {
                    return back()->withErrors([
                        'email' => 'Too many registration attempts. Please wait a minute and try again.',
                    ]);
                });
        });

        // 3. Time-in/out — 20 per minute per user (prevents spam submissions)
        RateLimiter::for('time-in-out', function (Request $request) {
            return Limit::perMinute(20)
                ->by($request->input('student_id') . '|' . $request->ip());
        });

        // 4. Password reset — 3 per 15 minutes per IP
        RateLimiter::for('password-reset', function (Request $request) {
            return Limit::perMinutes(15, 3)
                ->by($request->ip())
                ->response(function () {
                    return back()->withErrors([
                        'email' => 'Too many password reset attempts. Please wait 15 minutes.',
                    ]);
                });
        });

        // 5. General API routes — 60 per minute per IP
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->ip());
        });
    }
}
