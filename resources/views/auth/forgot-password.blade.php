<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Wachtwoord vergeten? - EventSamen</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="page">
        <div class="page-wrapper">
            <div class="container container-tight py-5">
                <div class="text-center mb-4">
                    <a
                        href="/"
                        class="navbar-brand navbar-brand-autodark text-decoration-none"
                    >
                        EventSamen
                    </a>
                </div>

                <div class="card card-md">
                    <div class="card-body">
                        <h2 class="h2 text-center mb-4">
                            Wachtwoord vergeten?
                        </h2>

                        <p class="text-secondary text-center mb-4">
                            Vul je e-mailadres in. Als er een account bestaat,
                            ontvang je instructies om je wachtwoord opnieuw in
                            te stellen.
                        </p>

                        @if (session('status'))
                            <div
                                class="alert alert-success"
                                role="alert"
                            >
                                <div>
                                    {{ session('status') }}
                                </div>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div
                                class="alert alert-danger"
                                role="alert"
                            >
                                <div>
                                    <h4 class="alert-title">
                                        Er ging iets mis
                                    </h4>

                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        @php
                            $passwordResetLocked =
                                $passwordResetLockedSeconds > 0;
                        @endphp

                        @if ($passwordResetLocked)
                            <div
                                class="alert alert-warning"
                                role="alert"
                            >
                                <div>
                                    <h4 class="alert-title">
                                        Even wachten
                                    </h4>

                                    <div>
                                        Te veel aanvragen achter elkaar.
                                        Probeer het opnieuw over
                                        <strong id="password-reset-countdown">
                                            {{ $passwordResetLockedSeconds }}
                                        </strong>
                                        seconden.
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form
                            method="POST"
                            action="/wachtwoord-vergeten"
                            id="forgot-password-form"
                        >
                            @csrf

                            <fieldset
                                @disabled($passwordResetLocked)
                            >
                                <div class="mb-3">
                                    <label
                                        for="email"
                                        class="form-label"
                                    >
                                        E-mailadres
                                    </label>

                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}"
                                        autocomplete="email"
                                        required
                                        autofocus
                                    >

                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-footer">
                                    <button
                                        type="submit"
                                        class="btn btn-primary w-100"
                                    >
                                        Resetinstructies aanvragen
                                    </button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>

                <div class="text-center text-secondary mt-3">
                    Weet je je wachtwoord weer?

                    <a href="/inloggen">
                        Terug naar inloggen
                    </a>
                </div>

                <div class="text-center text-secondary mt-4">
                    EventSamen — Ontdek. Ontmoet. Doe mee.
                </div>
            </div>
        </div>
    </div>

    @if ($passwordResetLocked)
        <script>
            (() => {
                let remaining = {{ $passwordResetLockedSeconds }};

                const countdown =
                    document.getElementById(
                        'password-reset-countdown'
                    );

                const interval = setInterval(() => {
                    remaining--;

                    if (remaining <= 0) {
                        clearInterval(interval);
                        window.location.reload();
                        return;
                    }

                    countdown.textContent = remaining;
                }, 1000);

                const form =
                    document.getElementById(
                        'forgot-password-form'
                    );

                form.addEventListener('submit', (event) => {
                    event.preventDefault();
                });
            })();
        </script>
    @endif
</body>
</html>