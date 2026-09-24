<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ChangePasswordController extends Controller
{
    /**
     * Show the change password page.
     */
    public function create()
    {
        return view('auth.change-password');
    }

    /**
     * Change the authenticated user's password.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'current_password' => [
                'required',
                'string',
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

        $user = $request->user();

        /*
         * Controleer eerst het huidige wachtwoord.
         */
        if (!Hash::check($validated['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Het huidige wachtwoord is niet juist.',
            ]);
        }

        /*
         * Voorkom dat hetzelfde wachtwoord opnieuw wordt gebruikt.
         */
        if (Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'password' => 'Je nieuwe wachtwoord moet verschillen van je huidige wachtwoord.',
            ]);
        }

        /*
         * Laravel hasht het wachtwoord via de cast op het User-model.
         */
        $user->password = $validated['password'];
        $user->save();

        /*
         * Vernieuw de sessie zodat de bestaande sessie veilig blijft.
         */
        $request->session()->regenerate();

        return redirect()
            ->route('profile.show')
            ->with(
                'status',
                'Je wachtwoord is gewijzigd.'
            );
    }
}