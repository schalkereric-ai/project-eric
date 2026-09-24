<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /**
     * Show the password reset form.
     */
    public function create(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    /**
     * Reset the user's password.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'token' => [
                'required',
                'string',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
            ],

            'password' => [
                'required',
                'confirmed',
                'string',
                'min:12',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[^a-zA-Z0-9]/',
            ],
        ]);

        $email = strtolower(trim($validated['email']));

        $reset = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$reset) {
            return back()->withErrors([
                'email' => 'Deze wachtwoordreset is niet geldig of is verlopen.',
            ]);
        }

        if (
            !$reset->created_at ||
            now()->diffInMinutes($reset->created_at) > 60
        ) {
            DB::table('password_reset_tokens')
                ->where('email', $email)
                ->delete();

            return back()->withErrors([
                'email' => 'Deze wachtwoordreset is niet geldig of is verlopen.',
            ]);
        }

        if (!Hash::check($validated['token'], $reset->token)) {
            return back()->withErrors([
                'email' => 'Deze wachtwoordreset is niet geldig of is verlopen.',
            ]);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Deze wachtwoordreset is niet geldig of is verlopen.',
            ]);
        }

        $user->password = $validated['password'];
        $user->save();

        DB::table('password_reset_tokens')
            ->where('email', $email)
            ->delete();

        return redirect('/inloggen')->with(
            'status',
            'Je wachtwoord is gewijzigd. Je kunt nu inloggen.'
        );
    }
}