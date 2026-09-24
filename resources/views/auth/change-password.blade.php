<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Wachtwoord wijzigen - EventSamen</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="page">

        <header class="navbar navbar-expand-md d-print-none">
            <div class="container-xl">

                <a
                    href="/"
                    class="navbar-brand text-decoration-none"
                >
                    <span class="navbar-brand-text">
                        EventSamen
                    </span>
                </a>

                <div class="navbar-nav flex-row order-md-last">
                    <div class="nav-item dropdown">

                        <a
                            href="#"
                            class="nav-link dropdown-toggle"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            {{ auth()->user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end">

                            <a
                                href="{{ route('profile.show') }}"
                                class="dropdown-item"
                            >
                                Mijn profiel
                            </a>

                            <a
                                href="/"
                                class="dropdown-item"
                            >
                                Mijn evenementen
                            </a>

                            <div class="dropdown-divider"></div>

                            <form
                                method="POST"
                                action="/uitloggen"
                            >
                                @csrf

                                <button
                                    type="submit"
                                    class="dropdown-item"
                                >
                                    Uitloggen
                                </button>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="navbar-nav">
                    <a
                        href="/"
                        class="nav-link"
                    >
                        Ontdek evenementen
                    </a>
                </div>

            </div>
        </header>


        <div class="page-wrapper">

            <div class="container-xl">

                <div class="page-header d-print-none">

                    <div class="row align-items-center">

                        <div class="col">

                            <div class="page-pretitle">
                                Account
                            </div>

                            <h2 class="page-title">
                                Wachtwoord wijzigen
                            </h2>

                        </div>

                    </div>

                </div>


                <div class="page-body">

                    <div class="row row-cards">

                        <div class="col-lg-8">

                            @if ($errors->any())
                                <div
                                    class="alert alert-danger"
                                    role="alert"
                                >

                                    <h4 class="alert-title">
                                        Controleer je gegevens
                                    </h4>

                                    <ul class="mb-0">

                                        @foreach ($errors->all() as $error)
                                            <li>
                                                {{ $error }}
                                            </li>
                                        @endforeach

                                    </ul>

                                </div>
                            @endif


                            <form
                                method="POST"
                                action="{{ route('password.update') }}"
                                class="card"
                                id="change-password-form"
                            >

                                @csrf
                                @method('PUT')


                                <div class="card-header">

                                    <h3 class="card-title">
                                        Nieuw wachtwoord
                                    </h3>

                                </div>


                                <div class="card-body">

                                    <div class="mb-3">

                                        <label
                                            for="current_password"
                                            class="form-label required"
                                        >
                                            Huidig wachtwoord
                                        </label>

                                        <div class="input-group">

                                            <input
                                                type="password"
                                                id="current_password"
                                                name="current_password"
                                                class="form-control @error('current_password') is-invalid @enderror"
                                                autocomplete="current-password"
                                                required
                                            >

                                            <button
                                                type="button"
                                                class="btn btn-outline-secondary password-toggle"
                                                data-target="current_password"
                                                aria-label="Wachtwoord tonen"
                                                title="Wachtwoord tonen"
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
                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                </svg>
                                            </button>

                                        </div>

                                        @error('current_password')
                                            <div class="text-danger mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    <div class="mb-3">

                                        <label
                                            for="password"
                                            class="form-label required"
                                        >
                                            Nieuw wachtwoord
                                        </label>

                                        <div class="input-group">

                                            <input
                                                type="password"
                                                id="password"
                                                name="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                autocomplete="new-password"
                                                required
                                            >

                                            <button
                                                type="button"
                                                class="btn btn-outline-secondary password-toggle"
                                                data-target="password"
                                                aria-label="Wachtwoord tonen"
                                                title="Wachtwoord tonen"
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
                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                </svg>
                                            </button>

                                        </div>

                                        @error('password')
                                            <div class="text-danger mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        <div class="form-hint mt-2">
                                            Je wachtwoord moet minimaal 12 tekens bevatten,
                                            inclusief een kleine letter, een cijfer en een speciaal teken.
                                        </div>

                                    </div>


                                    <div class="mb-0">

                                        <label
                                            for="password_confirmation"
                                            class="form-label required"
                                        >
                                            Nieuw wachtwoord opnieuw
                                        </label>

                                        <div class="input-group">

                                            <input
                                                type="password"
                                                id="password_confirmation"
                                                name="password_confirmation"
                                                class="form-control"
                                                autocomplete="new-password"
                                                required
                                            >

                                            <button
                                                type="button"
                                                class="btn btn-outline-secondary password-toggle"
                                                data-target="password_confirmation"
                                                aria-label="Wachtwoord tonen"
                                                title="Wachtwoord tonen"
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
                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                </svg>
                                            </button>

                                        </div>

                                    </div>

                                </div>


                                <div class="card-footer d-flex align-items-center">

                                    <a
                                        href="{{ route('profile.show') }}"
                                        class="btn btn-link"
                                    >
                                        Annuleren
                                    </a>

                                    <button
                                        type="submit"
                                        class="btn btn-primary ms-auto"
                                    >
                                        Wachtwoord wijzigen
                                    </button>

                                </div>

                            </form>

                        </div>


                        <div class="col-lg-4">

                            <div class="card">

                                <div class="card-header">

                                    <h3 class="card-title">
                                        Wachtwoordbeveiliging
                                    </h3>

                                </div>

                                <div class="card-body">

                                    <p class="text-secondary mb-0">
                                        Gebruik een uniek wachtwoord dat je
                                        nergens anders gebruikt.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <footer class="footer footer-transparent d-print-none">

                <div class="container-xl">

                    <div class="text-center text-secondary">
                        EventSamen — Ontdek. Ontmoet. Doe mee.
                    </div>

                </div>

            </footer>

        </div>

    </div>


    <script>
        document.querySelectorAll('.password-toggle').forEach((button) => {
            button.addEventListener('click', () => {
                const targetId = button.dataset.target;
                const input = document.getElementById(targetId);

                if (!input) {
                    return;
                }

                const isPassword = input.type === 'password';

                input.type = isPassword ? 'text' : 'password';

                button.setAttribute(
                    'aria-label',
                    isPassword
                        ? 'Wachtwoord verbergen'
                        : 'Wachtwoord tonen'
                );

                button.setAttribute(
                    'title',
                    isPassword
                        ? 'Wachtwoord verbergen'
                        : 'Wachtwoord tonen'
                );
            });
        });
    </script>

</body>
</html>