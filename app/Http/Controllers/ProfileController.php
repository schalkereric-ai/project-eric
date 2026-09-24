<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Show the user's profile.
     */
    public function show(Request $request)
    {
        return view('profile.show', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
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
        ]);

        $user = $request->user();

        $email = strtolower(trim($validated['email']));

        /*
         * Controleer of het e-mailadres daadwerkelijk verandert.
         */
        if ($email !== strtolower($user->email)) {
            /*
             * Een e-mailadres mag maar bij één account horen.
             */
            $emailExists = $user::where('email', $email)
                ->where('id', '!=', $user->id)
                ->exists();

            if ($emailExists) {
                return back()
                    ->withErrors([
                        'email' => 'Dit e-mailadres is al in gebruik.',
                    ])
                    ->withInput();
            }

            /*
             * Bij een wijziging van het e-mailadres vervalt
             * een eventuele bestaande verificatie.
             */
            $user->email_verified_at = null;
        }

        $user->name = $validated['name'];
        $user->email = $email;
        $user->save();

        /*
         * Vernieuw de sessie na het wijzigen van accountgegevens.
         */
        $request->session()->regenerate();

        return back()->with(
            'status',
            'Je profiel is opgeslagen.'
        );
    }
}