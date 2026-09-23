<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
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

        /*
         * We controleren bewust zelf of het e-mailadres al bestaat.
         *
         * We gebruiken hier NIET:
         *   'unique:users,email'
         *
         * Anders kunnen we via de validatiefout prijsgeven dat een
         * e-mailadres al bekend is bij EventSamen.
         */
        $existingUser = User::where('email', $email)->exists();

        if (!$existingUser) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $email,
                'password' => $validated['password'],
            ]);

            Auth::login($user);

            $request->session()->regenerate();
        }

        /*
         * Voor een bestaand én een nieuw e-mailadres geven we dezelfde
         * vervolgstap. Zo geven we niet prijs of het account al bestond.
         */
        return redirect('/inloggen')->with(
            'status',
            'Als registratie met dit e-mailadres mogelijk was, kun je nu inloggen.'
        );
    }
}