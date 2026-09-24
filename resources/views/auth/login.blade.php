<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Inloggen — EventSamen</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="d-flex flex-column min-vh-100">

    <header class="navbar navbar-expand-md">
        <div class="container-xl">

            <a class="navbar-brand" href="/">
                <span class="fw-bold">
                    EventSamen
                </span>
            </a>

            <div class="navbar-nav ms-auto">
                <a href="/registreren" class="nav-link">
                    Nog geen account?
                    <strong>Registreren</strong>
                </a>
            </div>

        </div>
    </header>

    <main class="flex-fill">

        <div class="container-tight py-5">

            <div class="text-center mb-4">

                <h1>
                    Welkom terug
                </h1>

                <p class="text-secondary">
                    Log in om verder te gaan met EventSamen.
                </p>

            </div>

            @php
                $loginLocked = $loginLockedSeconds > 0;
            @endphp

            @if (session('status'))
                <div class="alert alert-info mb-4" role="alert">
                    <div>
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            @if ($loginLocked)

                <div
                    class="alert alert-warning mb-4"
                    role="alert"
                >
                    <div class="d-flex align-items-start">

                        <div class="me-3 fs-2">
                            🔒
                        </div>

                        <div class="flex-fill">

                            <div class="fw-bold mb-1">
                                Even wachten
                            </div>

                            <div>
                                Je hebt te vaak geprobeerd in te loggen.
                                Probeer het over
                                <strong>
                                    <span id="login-countdown">
                                        {{ $loginLockedSeconds }}
                                    </span>
                                    seconden
                                </strong>
                                opnieuw.
                            </div>

                        </div>

                    </div>
                </div>

            @endif

            <form
                method="POST"
                action="/inloggen"
                class="card card-md"
                id="login-form"
            >

                @csrf

                <div class="card-body">

                    <fieldset
                        class="border-0 p-0 m-0"
                        @disabled($loginLocked)
                    >

                        <div class="mb-3">

                            <label
                                class="form-label"
                                for="email"
                            >
                                E-mailadres
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control @if (!$loginLocked && $errors->has('email')) is-invalid @endif"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="email"
                            >

                            @if (!$loginLocked)

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            @endif

                        </div>

                        <div class="mb-3">

                            <label
                                class="form-label"
                                for="password"
                            >
                                Wachtwoord
                            </label>

                            <div class="input-group input-group-flat">

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control @if (!$loginLocked && $errors->has('password')) is-invalid @endif"
                                    required
                                    autocomplete="current-password"
                                >

                                <button
                                    type="button"
                                    class="btn"
                                    id="toggle-password"
                                >
                                    Tonen
                                </button>

                            </div>

                            @if (!$loginLocked)

                                @error('password')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror

                            @endif

                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <label class="form-check mb-0">

                                <input
                                    type="checkbox"
                                    name="remember"
                                    class="form-check-input"
                                >

                                <span class="form-check-label">
                                    Ingelogd blijven
                                </span>

                            </label>

                            <a
                                href="/wachtwoord-vergeten"
                                class="text-decoration-none"
                            >
                                Wachtwoord vergeten?
                            </a>

                        </div>

                        <div class="form-footer">

                            <button
                                type="submit"
                                class="btn btn-primary w-100"
                                id="login-button"
                            >

                                @if ($loginLocked)

                                    <span id="login-button-text">
                                        Even wachten...
                                    </span>

                                @else

                                    Inloggen

                                @endif

                            </button>

                        </div>

                    </fieldset>

                </div>

            </form>

            <div class="text-center text-secondary mt-3">

                Nog geen account?

                <a href="/registreren">
                    Maak gratis een account aan
                </a>

            </div>

        </div>

    </main>

    <footer class="footer footer-transparent mt-auto">

        <div class="container-xl">

            <div class="text-center text-secondary">
                © {{ date('Y') }} EventSamen
            </div>

        </div>

    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const locked = @json($loginLocked);

            const form = document.getElementById('login-form');

            const loginButton =
                document.getElementById('login-button');

            const password =
                document.getElementById('password');

            const togglePassword =
                document.getElementById('toggle-password');

            if (togglePassword && password) {

                togglePassword.addEventListener('click', function () {

                    if (password.type === 'password') {

                        password.type = 'text';

                        togglePassword.textContent =
                            'Verbergen';

                    } else {

                        password.type = 'password';

                        togglePassword.textContent =
                            'Tonen';

                    }

                });

            }

            if (!locked) {
                return;
            }

            form.addEventListener(
                'submit',
                function (event) {

                    event.preventDefault();
                    event.stopPropagation();

                },
                true
            );

            document.addEventListener(
                'keydown',
                function (event) {

                    if (event.key === 'Enter') {

                        event.preventDefault();
                        event.stopPropagation();

                    }

                },
                true
            );

            const countdown =
                document.getElementById('login-countdown');

            const buttonText =
                document.getElementById('login-button-text');

            let remaining =
                Number(countdown.textContent);

            const timer =
                setInterval(function () {

                    remaining--;

                    if (remaining <= 0) {

                        clearInterval(timer);

                        window.location.reload();

                        return;
                    }

                    countdown.textContent =
                        remaining;

                    if (buttonText) {

                        if (remaining === 1) {

                            buttonText.textContent =
                                'Nog 1 seconde...';

                        } else {

                            buttonText.textContent =
                                'Nog ' +
                                remaining +
                                ' seconden...';

                        }

                    }

                }, 1000);

        });
    </script>

</body>
</html>