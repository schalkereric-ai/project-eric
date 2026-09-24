<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mijn profiel - EventSamen</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="page">
        <header class="navbar navbar-expand-md d-print-none">
            <div class="container-xl">
                <a href="/" class="navbar-brand text-decoration-none">
                    <span class="navbar-brand-text">
                        EventSamen
                    </span>
                </a>

                <div class="navbar-nav flex-row order-md-last">
                    <div class="nav-item dropdown">
                        <a
                            href="#"
                            class="nav-link d-flex lh-1 text-reset p-0"
                            data-bs-toggle="dropdown"
                            aria-label="Open gebruikersmenu"
                        >
                            <span class="avatar avatar-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>

                            <div class="d-none d-xl-block ps-2">
                                <div>{{ $user->name }}</div>

                                <div class="mt-1 small text-secondary">
                                    {{ $user->email }}
                                </div>
                            </div>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <a
                                href="{{ route('profile.show') }}"
                                class="dropdown-item active"
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

                            <form method="POST" action="/uitloggen">
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
                    <a href="/" class="nav-link">
                        <span class="nav-link-title">
                            Ontdek evenementen
                        </span>
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
                                Mijn profiel
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="page-body">
                    <div class="row row-cards">
                        <div class="col-lg-8">
                            @if (session('status'))
                                <div
                                    class="alert alert-success alert-dismissible"
                                    role="alert"
                                >
                                    <div>
                                        <h4 class="alert-title">
                                            Opgeslagen
                                        </h4>

                                        <div class="text-secondary">
                                            {{ session('status') }}
                                        </div>
                                    </div>

                                    <a
                                        class="btn-close"
                                        data-bs-dismiss="alert"
                                        aria-label="Sluiten"
                                    ></a>
                                </div>
                            @endif

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
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form
                                method="POST"
                                action="{{ route('profile.update') }}"
                                class="card"
                            >
                                @csrf
                                @method('PUT')

                                <div class="card-header">
                                    <h3 class="card-title">
                                        Persoonlijke gegevens
                                    </h3>
                                </div>

                                <div class="card-body">
                                    <div class="mb-3">
                                        <label
                                            for="name"
                                            class="form-label required"
                                        >
                                            Naam
                                        </label>

                                        <input
                                            type="text"
                                            id="name"
                                            name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $user->name) }}"
                                            maxlength="255"
                                            required
                                            autocomplete="name"
                                        >

                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-0">
                                        <label
                                            for="email"
                                            class="form-label required"
                                        >
                                            E-mailadres
                                        </label>

                                        <input
                                            type="email"
                                            id="email"
                                            name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $user->email) }}"
                                            maxlength="255"
                                            required
                                            autocomplete="email"
                                        >

                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        <div class="form-hint">
                                            Je kunt hier het e-mailadres van je account wijzigen.
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer d-flex align-items-center">
                                    <a
                                        href="/"
                                        class="btn btn-link"
                                    >
                                        Annuleren
                                    </a>

                                    <button
                                        type="submit"
                                        class="btn btn-primary ms-auto"
                                    >
                                        Wijzigingen opslaan
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Account
                                    </h3>
                                </div>

                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="avatar avatar-lg me-3">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>

                                        <div>
                                            <div class="fw-bold">
                                                {{ $user->name }}
                                            </div>

                                            <div class="text-secondary">
                                                {{ $user->email }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-secondary">
                                        Dit is je persoonlijke EventSamen-account.
                                        Vanuit hier kun je je profielgegevens
                                        beheren.
                                    </div>
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-body">
                                    <h3 class="card-title">
                                        Beveiliging
                                    </h3>

                                    <p class="text-secondary mb-3">
                                        Wil je je wachtwoord wijzigen?
                                    </p>

                                    <a
                                        href="{{ route('password.change') }}"
                                        class="btn btn-outline-secondary w-100"
                                    >
                                        Wachtwoord wijzigen
                                    </a>
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
</body>
</html>