<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * Show the login page.
     */
    public function create()
    {
        $loginLockedSeconds = (int) session('login_locked_seconds', 0);

        return view('auth.login', [
            'loginLockedSeconds' => $loginLockedSeconds,
        ]);
    }

    /**
     * Handle a login attempt.
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'string',
            ],
        ]);

        $email = Str::lower(trim($credentials['email']));

        $loginKey = 'login:' . hash(
            'sha256',
            $email . '|' . $request->ip()
        );

        $failureKey = 'login-failures:' . hash(
            'sha256',
            $email . '|' . $request->ip()
        );

        /*
         * Er is al een actieve blokkering.
         */
        if (RateLimiter::tooManyAttempts($loginKey, 1)) {
            $seconds = RateLimiter::availableIn($loginKey);

            return redirect('/inloggen')
                ->with('login_locked_seconds', $seconds)
                ->withErrors([
                    'email' => $this->lockoutMessage($seconds),
                ])
                ->withInput(['email' => $email]);
        }

        /*
         * Probeer in te loggen.
         */
        if (Auth::attempt(
            [
                'email' => $email,
                'password' => $credentials['password'],
            ],
            $request->boolean('remember')
        )) {
            $request->session()->regenerate();

            RateLimiter::clear($loginKey);
            RateLimiter::clear($failureKey);

            return redirect('/');
        }

        /*
         * Login mislukt.
         */
        RateLimiter::hit($failureKey, 86400);

        $failures = RateLimiter::attempts($failureKey);

        /*
         * Na iedere vijf mislukte pogingen:
         *
         * 5  -> 1 minuut
         * 10 -> 2 minuten
         * 15 -> 4 minuten
         * 20 -> 8 minuten
         *
         * Maximum 1 uur.
         */
        if ($failures >= 5) {
            $level = intdiv($failures, 5);

            $lockoutSeconds = min(
                3600,
                60 * (2 ** ($level - 1))
            );

            RateLimiter::hit($loginKey, $lockoutSeconds);

            return redirect('/inloggen')
                ->with('login_locked_seconds', $lockoutSeconds)
                ->withErrors([
                    'email' => $this->lockoutMessage($lockoutSeconds),
                ])
                ->withInput(['email' => $email]);
        }

        return back()
            ->withErrors([
                'email' => 'De combinatie van e-mailadres en wachtwoord is niet juist.',
            ])
            ->onlyInput('email');
    }

    /**
     * Log the user out.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Create a friendly lockout message.
     */
    private function lockoutMessage(int $seconds): string
    {
        if ($seconds >= 60) {
            $minutes = (int) ceil($seconds / 60);

            return $minutes === 1
                ? 'Te veel mislukte inlogpogingen. Probeer het over ongeveer 1 minuut opnieuw.'
                : "Te veel mislukte inlogpogingen. Probeer het over ongeveer {$minutes} minuten opnieuw.";
        }

        return "Te veel mislukte inlogpogingen. Probeer het over {$seconds} seconden opnieuw.";
    }
}