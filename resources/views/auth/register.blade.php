<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Account aanmaken - EventSamen</title>
</head>

<body>
    <div class="page">

        {{-- Navigatie --}}
        <header class="navbar navbar-expand-md d-print-none">
            <div class="container-xl">

                <a class="navbar-brand text-decoration-none" href="/">
                    EventSamen
                </a>

                <div class="navbar-nav flex-row order-md-last">
                    <div class="nav-item">
                        <a href="/" class="nav-link">
                            Ontdek evenementen
                        </a>
                    </div>

                    <div class="nav-item">
                        <a href="#" class="btn btn-outline-primary">
                            Inloggen
                        </a>
                    </div>
                </div>

            </div>
        </header>

        {{-- Registratie --}}
        <div class="page-wrapper">

            <div class="container-xl py-5">

                <div class="row justify-content-center">

                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">

                        <div class="text-center mb-4">

                            <h1 class="mb-2">
                                Account aanmaken
                            </h1>

                            <p class="text-secondary">
                                Doe mee met evenementen en ontdek nieuwe mensen.
                            </p>

                        </div>

                        <div class="card">

                            <div class="card-body p-4 p-md-5">

                                <form method="POST" action="/registreren">
                                    @csrf

                                    {{-- Naam --}}
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Naam
                                        </label>

                                        <input
                                            type="text"
                                            class="form-control"
                                            name="name"
                                            autocomplete="name"
                                            placeholder="Je naam"
                                        >

                                    </div>

                                    {{-- E-mail --}}
                                    <div class="mb-3">

                                        <label class="form-label">
                                            E-mailadres
                                        </label>

                                        <input
                                            type="email"
                                            class="form-control"
                                            name="email"
                                            autocomplete="email"
                                            placeholder="naam@voorbeeld.nl"
                                        >

                                    </div>

                                    {{-- Wachtwoord --}}
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Wachtwoord
                                        </label>

                                        <div class="input-group">

                                            <input
                                                type="password"
                                                class="form-control"
                                                id="password"
                                                name="password"
                                                autocomplete="new-password"
                                                placeholder="Kies een sterk wachtwoord"
                                            >

                                            <button
                                                type="button"
                                                class="btn btn-outline-secondary"
                                                id="toggle-password"
                                                aria-label="Wachtwoord tonen"
                                            >
                                                👁
                                            </button>

                                        </div>

                                        <div class="mt-3">

                                            <div class="small fw-semibold mb-2">
                                                Je wachtwoord moet:
                                            </div>

                                            <div
                                                id="password-rules"
                                                class="small"
                                            >

                                                <div id="rule-length" class="text-secondary">
                                                    ○ Minimaal 12 karakters
                                                </div>

                                                <div id="rule-letter" class="text-secondary">
                                                    ○ Minimaal één kleine letter (a-z)
                                                </div>

                                                <div id="rule-number" class="text-secondary">
                                                    ○ Minimaal één cijfer (0-9)
                                                </div>

                                                <div id="rule-special" class="text-secondary">
                                                    ○ Minimaal één speciaal teken
                                                </div>

                                            </div>

                                        </div>

                                        <div
                                            id="password-strength"
                                            class="mt-3"
                                            style="display: none;"
                                        >

                                            <div class="progress mb-2">
                                                <div
                                                    id="password-strength-bar"
                                                    class="progress-bar"
                                                    role="progressbar"
                                                    style="width: 0%"
                                                ></div>
                                            </div>

                                            <div
                                                id="password-strength-text"
                                                class="small text-secondary"
                                            ></div>

                                        </div>

                                    </div>

                                    {{-- Bevestig wachtwoord --}}
                                    <div class="mb-4">

                                        <label class="form-label">
                                            Wachtwoord opnieuw
                                        </label>

                                        <input
                                            type="password"
                                            class="form-control"
                                            id="password-confirmation"
                                            name="password_confirmation"
                                            autocomplete="new-password"
                                            placeholder="Herhaal je wachtwoord"
                                        >

                                        <div
                                            id="password-match"
                                            class="small mt-2"
                                        ></div>

                                    </div>

                                    {{-- Submit --}}
                                    <button
                                        type="submit"
                                        id="register-button"
                                        class="btn btn-primary w-100"
                                        disabled
                                    >
                                        Account aanmaken
                                    </button>

                                </form>

                            </div>

                        </div>

                        <div class="text-center mt-4">

                            <span class="text-secondary">
                                Heb je al een account?
                            </span>

                            <a href="#">
                                Inloggen
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <footer class="footer footer-transparent d-print-none">

            <div class="container-xl">

                <div class="text-center text-secondary">
                    © {{ date('Y') }} EventSamen
                </div>

            </div>

        </footer>

    </div>

    <script>
        const password = document.getElementById('password');
        const confirmation = document.getElementById('password-confirmation');
        const togglePassword = document.getElementById('toggle-password');
        const registerButton = document.getElementById('register-button');

        const ruleLength = document.getElementById('rule-length');
        const ruleLetter = document.getElementById('rule-letter');
        const ruleNumber = document.getElementById('rule-number');
        const ruleSpecial = document.getElementById('rule-special');

        const strengthContainer = document.getElementById('password-strength');
        const strengthBar = document.getElementById('password-strength-bar');
        const strengthText = document.getElementById('password-strength-text');
        const passwordMatch = document.getElementById('password-match');

        function updateRule(element, valid, text) {
            element.textContent = (valid ? '✓ ' : '○ ') + text;

            element.classList.toggle('text-success', valid);
            element.classList.toggle('text-secondary', !valid);
        }

        function validatePassword() {
            const value = password.value;

            const validLength = value.length >= 12;
            const validLetter = /[a-z]/.test(value);
            const validNumber = /[0-9]/.test(value);
            const validSpecial = /[^a-zA-Z0-9]/.test(value);

            updateRule(
                ruleLength,
                validLength,
                'Minimaal 12 karakters'
            );

            updateRule(
                ruleLetter,
                validLetter,
                'Minimaal één kleine letter (a-z)'
            );

            updateRule(
                ruleNumber,
                validNumber,
                'Minimaal één cijfer (0-9)'
            );

            updateRule(
                ruleSpecial,
                validSpecial,
                'Minimaal één speciaal teken'
            );

            const score = [
                validLength,
                validLetter,
                validNumber,
                validSpecial
            ].filter(Boolean).length;

            if (value.length === 0) {
                strengthContainer.style.display = 'none';
            } else {
                strengthContainer.style.display = 'block';

                const percentage = score * 25;

                strengthBar.style.width = percentage + '%';

                if (score <= 1) {
                    strengthText.textContent = 'Dit wachtwoord voldoet nog niet.';
                } else if (score === 2) {
                    strengthText.textContent = 'Nog wat verbeteren.';
                } else if (score === 3) {
                    strengthText.textContent = 'Bijna goed.';
                } else {
                    strengthText.textContent = 'Dit wachtwoord voldoet aan de basisregels.';
                }
            }

            validateForm();
        }

        function validateConfirmation() {
            if (confirmation.value === '') {
                passwordMatch.textContent = '';
                return;
            }

            if (password.value === confirmation.value) {
                passwordMatch.textContent = '✓ Wachtwoorden komen overeen.';
                passwordMatch.className = 'small mt-2 text-success';
            } else {
                passwordMatch.textContent = '✗ Wachtwoorden komen niet overeen.';
                passwordMatch.className = 'small mt-2 text-danger';
            }

            validateForm();
        }

        function validateForm() {
            const validPassword =
                password.value.length >= 12 &&
                /[a-z]/.test(password.value) &&
                /[0-9]/.test(password.value) &&
                /[^a-zA-Z0-9]/.test(password.value);

            const passwordsMatch =
                password.value !== '' &&
                password.value === confirmation.value;

            registerButton.disabled =
                !(validPassword && passwordsMatch);
        }

        togglePassword.addEventListener('click', function () {
            const type =
                password.type === 'password'
                    ? 'text'
                    : 'password';

            password.type = type;
            confirmation.type = type;

            this.textContent = type === 'password' ? '👁' : '🙈';
        });

        password.addEventListener('input', validatePassword);
        confirmation.addEventListener('input', validateConfirmation);
    </script>

</body>
</html>