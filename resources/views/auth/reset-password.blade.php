<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Nieuw wachtwoord instellen - EventSamen</title>
</head>

<body>

    <div class="page">

        {{-- Navigatie --}}
        <header class="navbar navbar-expand-md d-print-none">

            <div class="container-xl">

                <a class="navbar-brand text-decoration-none" href="/">
                    <span class="navbar-brand-text">
                        EventSamen
                    </span>
                </a>

                <div class="navbar-nav ms-auto">

                    <div class="nav-item">
                        <a href="/inloggen" class="btn btn-outline-primary">
                            Inloggen
                        </a>
                    </div>

                </div>

            </div>

        </header>


        {{-- Inhoud --}}
        <div class="page-wrapper">

            <div class="container container-tight py-5">

                <div class="card card-md">

                    <div class="card-body">

                        <div class="text-center mb-4">

                            <h1 class="mb-2">
                                Nieuw wachtwoord instellen
                            </h1>

                            <p class="text-secondary mb-0">
                                Kies een nieuw, sterk wachtwoord voor je account.
                            </p>

                        </div>


                        {{-- Foutmeldingen --}}
                        @if ($errors->any())

                            <div class="alert alert-danger mb-4">

                                <div class="d-flex">

                                    <div>
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="icon alert-icon"
                                        >
                                            <circle cx="12" cy="12" r="9"></circle>
                                            <line x1="12" y1="8" x2="12" y2="12"></line>
                                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                        </svg>
                                    </div>

                                    <div>

                                        <h4 class="alert-title">
                                            Wachtwoord niet gewijzigd
                                        </h4>

                                        <div>
                                            @foreach ($errors->all() as $error)
                                                <div>{{ $error }}</div>
                                            @endforeach
                                        </div>

                                    </div>

                                </div>

                            </div>

                        @endif


                        <form
                            method="POST"
                            action="/wachtwoord-resetten"
                            id="reset-password-form"
                        >

                            @csrf

                            <input
                                type="hidden"
                                name="token"
                                value="{{ $token }}"
                            >


                            {{-- E-mailadres --}}
                            <div class="mb-3">

                                <label
                                    class="form-label"
                                    for="email"
                                >
                                    E-mailadres
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    value="{{ old('email', $email) }}"
                                    class="form-control"
                                    readonly
                                >

                            </div>


                            {{-- Nieuw wachtwoord --}}
                            <div class="mb-3">

                                <label
                                    class="form-label"
                                    for="password"
                                >
                                    Nieuw wachtwoord
                                </label>

                                <div class="input-group input-group-flat">

                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        class="form-control"
                                        autocomplete="new-password"
                                        required
                                        autofocus
                                    >

                                    <button
                                        type="button"
                                        class="btn"
                                        id="toggle-password"
                                        aria-label="Wachtwoord tonen"
                                        title="Wachtwoord tonen"
                                    >

                                        <svg
                                            id="password-eye"
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="icon"
                                        >
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path>
                                        </svg>

                                    </button>

                                </div>

                            </div>


                            {{-- Wachtwoordregels --}}
                            <div class="mb-3">

                                <div class="text-secondary small mb-2">
                                    Je wachtwoord moet minimaal bevatten:
                                </div>

                                <div
                                    id="password-rules"
                                    class="small"
                                >

                                    <div id="rule-length">
                                        <span class="rule-icon">○</span>
                                        Minimaal 12 tekens
                                    </div>

                                    <div id="rule-lowercase">
                                        <span class="rule-icon">○</span>
                                        Minimaal één kleine letter
                                    </div>

                                    <div id="rule-number">
                                        <span class="rule-icon">○</span>
                                        Minimaal één cijfer
                                    </div>

                                    <div id="rule-special">
                                        <span class="rule-icon">○</span>
                                        Minimaal één speciaal teken
                                    </div>

                                </div>

                            </div>


                            {{-- Bevestiging --}}
                            <div class="mb-4">

                                <label
                                    class="form-label"
                                    for="password_confirmation"
                                >
                                    Herhaal je nieuwe wachtwoord
                                </label>

                                <div class="input-group input-group-flat">

                                    <input
                                        type="password"
                                        name="password_confirmation"
                                        id="password_confirmation"
                                        class="form-control"
                                        autocomplete="new-password"
                                        required
                                    >

                                    <button
                                        type="button"
                                        class="btn"
                                        id="toggle-password-confirmation"
                                        aria-label="Bevestiging tonen"
                                        title="Bevestiging tonen"
                                    >

                                        <svg
                                            id="password-confirmation-eye"
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="icon"
                                        >
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path>
                                        </svg>

                                    </button>

                                </div>

                                <div
                                    id="password-match"
                                    class="small mt-2"
                                ></div>

                            </div>


                            {{-- Submit --}}
                            <button
                                type="submit"
                                id="submit-button"
                                class="btn btn-primary w-100"
                                disabled
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon"
                                >
                                    <path d="M5 12l5 5l10 -10"></path>
                                </svg>

                                Nieuw wachtwoord instellen
                            </button>

                        </form>


                        <div class="text-center mt-4">

                            <a
                                href="/inloggen"
                                class="text-secondary"
                            >
                                Terug naar inloggen
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Footer --}}
        <footer class="footer footer-transparent d-print-none">

            <div class="container-xl">

                <div class="text-center text-secondary">
                    © {{ date('Y') }} EventSamen
                </div>

            </div>

        </footer>

    </div>


    <script>
        (() => {
            const password = document.getElementById('password');
            const confirmation = document.getElementById('password_confirmation');

            const submitButton = document.getElementById('submit-button');

            const matchMessage = document.getElementById('password-match');

            const ruleLength = document.getElementById('rule-length');
            const ruleLowercase = document.getElementById('rule-lowercase');
            const ruleNumber = document.getElementById('rule-number');
            const ruleSpecial = document.getElementById('rule-special');


            function updateRule(element, valid) {
                const icon = element.querySelector('.rule-icon');

                if (valid) {
                    icon.textContent = '✓';
                    element.classList.add('text-success');
                    element.classList.remove('text-secondary');
                } else {
                    icon.textContent = '○';
                    element.classList.remove('text-success');
                    element.classList.add('text-secondary');
                }
            }


            function updateValidation() {
                const value = password.value;
                const confirmationValue = confirmation.value;

                const validLength = value.length >= 12;
                const validLowercase = /[a-z]/.test(value);
                const validNumber = /[0-9]/.test(value);
                const validSpecial = /[^a-zA-Z0-9]/.test(value);

                const passwordsMatch =
                    value.length > 0 &&
                    value === confirmationValue;


                updateRule(
                    ruleLength,
                    validLength
                );

                updateRule(
                    ruleLowercase,
                    validLowercase
                );

                updateRule(
                    ruleNumber,
                    validNumber
                );

                updateRule(
                    ruleSpecial,
                    validSpecial
                );


                if (confirmationValue.length === 0) {
                    matchMessage.textContent = '';
                    matchMessage.className = 'small mt-2';

                } else if (passwordsMatch) {
                    matchMessage.textContent =
                        'De wachtwoorden komen overeen.';

                    matchMessage.className =
                        'small mt-2 text-success';

                } else {
                    matchMessage.textContent =
                        'De wachtwoorden komen niet overeen.';

                    matchMessage.className =
                        'small mt-2 text-danger';
                }


                submitButton.disabled = !(
                    validLength &&
                    validLowercase &&
                    validNumber &&
                    validSpecial &&
                    passwordsMatch
                );
            }


            function togglePassword(
                input,
                button,
                eye,
                labelShow,
                labelHide
            ) {
                const visible = input.type === 'text';

                input.type = visible ? 'password' : 'text';

                button.setAttribute(
                    'aria-label',
                    visible ? labelShow : labelHide
                );

                button.setAttribute(
                    'title',
                    visible ? labelShow : labelHide
                );


                if (visible) {

                    eye.innerHTML = `
                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path>
                    `;

                } else {

                    eye.innerHTML = `
                        <path d="M10.5 10.5a2 2 0 0 0 2.99 2.99"></path>
                        <path d="M13.8 8.2a9.9 9.9 0 0 1 8.2 3.8c-2.4 4 -5.4 6 -9 6c-1.2 0 -2.3 -0.2 -3.3 -0.6"></path>
                        <path d="M6.6 6.6c-1.4 1.1 -2.6 2.6 -3.6 4.4c2.4 4 5.4 6 9 6"></path>
                        <path d="M3 3l18 18"></path>
                    `;
                }
            }


            const togglePasswordButton =
                document.getElementById('toggle-password');

            const passwordEye =
                document.getElementById('password-eye');


            togglePasswordButton.addEventListener(
                'click',
                () => {
                    togglePassword(
                        password,
                        togglePasswordButton,
                        passwordEye,
                        'Wachtwoord tonen',
                        'Wachtwoord verbergen'
                    );
                }
            );


            const toggleConfirmationButton =
                document.getElementById(
                    'toggle-password-confirmation'
                );

            const confirmationEye =
                document.getElementById(
                    'password-confirmation-eye'
                );


            toggleConfirmationButton.addEventListener(
                'click',
                () => {
                    togglePassword(
                        confirmation,
                        toggleConfirmationButton,
                        confirmationEye,
                        'Bevestiging tonen',
                        'Bevestiging verbergen'
                    );
                }
            );


            password.addEventListener(
                'input',
                updateValidation
            );

            confirmation.addEventListener(
                'input',
                updateValidation
            );


            updateValidation();
        })();
    </script>

</body>

</html>