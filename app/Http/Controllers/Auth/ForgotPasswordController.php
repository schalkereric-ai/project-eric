<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Show the forgot password page.
     */
    public function create(Request $request)
    {
        $lockedSeconds = (int) $request->session()->pull(
            'password_reset_locked_seconds',
            0
        );

        return view('auth.forgot-password', [
            'passwordResetLockedSeconds' => $lockedSeconds,
        ]);
    }

    /**
     * Send password reset instructions.
     */
    public function store(Request $request, RateLimiter $limiter)
    {
        $validated = $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
            ],
        ]);

        $email = strtolower(trim($validated['email']));

        $ipKey = 'password-reset:ip:' . $request->ip();

        $emailIpKey = 'password-reset:email-ip:' . hash(
            'sha256',
            $email . '|' . $request->ip()
        );

        $ipLockKey = $ipKey . ':lock';

        $emailIpLockKey = $emailIpKey . ':lock';

        /*
         * Controleer of er al een actieve blokkade is.
         */
        if (
            $limiter->tooManyAttempts($ipLockKey, 1) ||
            $limiter->tooManyAttempts($emailIpLockKey, 1)
        ) {
            $lockedSeconds = max(
                $limiter->availableIn($ipLockKey),
                $limiter->availableIn($emailIpLockKey)
            );

            return back()->with(
                'password_reset_locked_seconds',
                $lockedSeconds
            );
        }

        /*
         * Bepaal hoeveel aanvragen er al zijn gedaan.
         */
        $attempts = max(
            $limiter->attempts($ipKey),
            $limiter->attempts($emailIpKey)
        );

        $nextAttemptNumber = $attempts + 1;

        /*
         * Registreer deze aanvraag.
         *
         * De teller blijft maximaal 24 uur bestaan.
         * De daadwerkelijke blokkade gebruikt een aparte sleutel.
         */
        $limiter->hit($ipKey, 86400);
        $limiter->hit($emailIpKey, 86400);

        /*
         * Na iedere 5 toegestane aanvragen wordt
         * de volgende aanvraag tijdelijk geblokkeerd.
         *
         * 5 aanvragen  -> volgende poging 1 minuut blokkade
         * 10 aanvragen -> volgende poging 2 minuten blokkade
         * 15 aanvragen -> volgende poging 4 minuten blokkade
         * 20 aanvragen -> volgende poging 8 minuten blokkade
         * enzovoort.
         *
         * Maximum = 1 uur.
         */
        if (
            $nextAttemptNumber > 5 &&
            $nextAttemptNumber % 5 === 1
        ) {
            $lockLevel = intdiv(
                $nextAttemptNumber - 1,
                5
            );

            $lockedSeconds = min(
                3600,
                60 * (2 ** ($lockLevel - 1))
            );

            $limiter->hit(
                $ipLockKey,
                $lockedSeconds
            );

            $limiter->hit(
                $emailIpLockKey,
                $lockedSeconds
            );

            return back()->with(
                'password_reset_locked_seconds',
                $lockedSeconds
            );
        }

        /*
         * Zoek het account op.
         *
         * We geven nooit aan of een e-mailadres bestaat.
         */
        $user = User::where('email', $email)->first();

        /*
         * Bestaat het account niet?
         *
         * We maken geen reset-token aan, maar geven exact
         * dezelfde melding als bij een bestaand account.
         *
         * Een dummy hash verkleint het verschil in verwerkingstijd.
         */
        if (!$user) {
            Hash::make(Str::random(64));

            return back()->with(
                'status',
                'Aanvraag verwerkt. Als er een account is met dit e-mailadres, hebben we de instructies om je wachtwoord opnieuw in te stellen klaargezet. Controleer je inbox. Heb je niets ontvangen? Controleer dan ook je spamfolder.'
            );
        }

        /*
         * Genereer een cryptografisch veilige reset-token.
         */
        $token = Str::random(64);

        /*
         * Sla alleen de hash van de token op.
         * De originele token komt nooit in de database.
         */
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        /*
         * Tijdens development schrijven we de resetlink
         * tijdelijk naar de Laravel-log.
         *
         * Later vervangen we dit door echte e-mailverzending.
         */
        $resetUrl = url('/wachtwoord-resetten/' . $token)
            . '?email='
            . urlencode($email);

        logger()->info('Password reset URL generated', [
            'email' => $email,
            'url' => $resetUrl,
        ]);

        return back()->with(
            'status',
            'Aanvraag verwerkt. Als er een account is met dit e-mailadres, hebben we de instructies om je wachtwoord opnieuw in te stellen klaargezet. Controleer je inbox. Heb je niets ontvangen? Controleer dan ook je spamfolder.'
        );
    }
}