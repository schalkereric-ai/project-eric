<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>EventSamen</title>
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

                <div class="navbar-nav flex-row order-md-last">
                    @auth
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
                                <a href="#" class="dropdown-item">
                                    Mijn profiel
                                </a>

                                <a href="#" class="dropdown-item">
                                    Mijn evenementen
                                </a>

                                <div class="dropdown-divider"></div>

                                <form method="POST" action="/uitloggen">
                                    @csrf

                                    <button type="submit" class="dropdown-item">
                                        Uitloggen
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="nav-item">
                            <a href="/inloggen" class="btn btn-outline-primary">
                                Inloggen
                            </a>
                        </div>
                    @endauth
                </div>

                <div class="navbar-nav d-none d-md-flex">
                    <div class="nav-item">
                        <a href="#events" class="nav-link">
                            Ontdek evenementen
                        </a>
                    </div>

                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            Organiseer een evenement
                        </a>
                    </div>
                </div>

            </div>
        </header>

        {{-- Hero --}}
        <div class="page-wrapper">

            <div class="container-xl py-5">

                <div class="row justify-content-center text-center py-5">

                    <div class="col-lg-8">

                        <div class="mb-3">
                            <span class="badge bg-primary-lt">
                                Samen is leuker
                            </span>
                        </div>

                        <h1 class="display-4 fw-bold mb-4">
                            Ontdek. Ontmoet. Doe mee.
                        </h1>

                        <p class="text-secondary fs-2 mb-5">
                            Vind leuke evenementen en mensen om ze samen mee te beleven.
                        </p>

                        {{-- Zoekbalk --}}
                        <div class="card shadow-sm">
                            <div class="card-body p-2">

                                <div class="input-group input-group-lg">

                                    <span class="input-group-text border-0">
                                        🔎
                                    </span>

                                    <input
                                        type="text"
                                        class="form-control border-0"
                                        placeholder="Waar heb je zin in?"
                                    >

                                    <button class="btn btn-primary">
                                        Zoeken
                                    </button>

                                </div>

                            </div>
                        </div>

                    </div>

                </div>

                {{-- Categorieën --}}
                <div class="mb-5">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="mb-0">
                            Waar heb je zin in?
                        </h2>
                    </div>

                    <div class="row row-cards">

                        @foreach ([
                            ['🎵', 'Concerten'],
                            ['🎭', 'Theater'],
                            ['🎉', 'Feesten'],
                            ['🏃', 'Sport'],
                            ['🍽️', 'Eten & drinken'],
                            ['🚶', 'Buiten'],
                        ] as [$icon, $name])

                            <div class="col-6 col-md-4 col-lg-2">

                                <a href="#" class="card card-link h-100 text-decoration-none">

                                    <div class="card-body text-center py-4">

                                        <div class="fs-1 mb-2">
                                            {{ $icon }}
                                        </div>

                                        <div class="fw-bold">
                                            {{ $name }}
                                        </div>

                                    </div>

                                </a>

                            </div>

                        @endforeach

                    </div>

                </div>

                {{-- Voorbeeld evenementen --}}
                <div id="events">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <div>
                            <h2 class="mb-1">
                                Ontdek evenementen
                            </h2>

                            <div class="text-secondary">
                                Misschien zit er iets voor jou tussen.
                            </div>
                        </div>

                        <a href="#" class="btn btn-outline-primary">
                            Alles bekijken
                        </a>

                    </div>

                    <div class="row row-cards">

                        @foreach ([
                            [
                                '🎵',
                                'Live concert',
                                'Amsterdam',
                                '12 oktober',
                                '8 mensen gaan'
                            ],
                            [
                                '🎭',
                                'Theateravond',
                                'Alkmaar',
                                '18 oktober',
                                '14 mensen gaan'
                            ],
                            [
                                '🍽️',
                                'Samen uit eten',
                                'Haarlem',
                                '20 oktober',
                                '6 mensen gaan'
                            ],
                        ] as [$icon, $title, $location, $date, $participants])

                            <div class="col-md-6 col-lg-4">

                                <div class="card h-100">

                                    <div class="card-body">

                                        <div class="d-flex align-items-center mb-4">

                                            <div class="avatar avatar-lg me-3">
                                                {{ $icon }}
                                            </div>

                                            <div>
                                                <h3 class="card-title mb-1">
                                                    {{ $title }}
                                                </h3>

                                                <div class="text-secondary">
                                                    {{ $location }}
                                                </div>
                                            </div>

                                        </div>

                                        <div class="text-secondary mb-3">
                                            📅 {{ $date }}
                                        </div>

                                        <div class="text-secondary">
                                            👥 {{ $participants }}
                                        </div>

                                    </div>

                                    <div class="card-footer">

                                        <a href="#" class="btn btn-primary w-100">
                                            Bekijk evenement
                                        </a>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

                {{-- Organiseren --}}
                <div class="card bg-primary text-primary-fg mt-5">

                    <div class="card-body p-5">

                        <div class="row align-items-center">

                            <div class="col">

                                <h2 class="mb-2">
                                    Organiseer zelf iets
                                </h2>

                                <p class="mb-0 opacity-75">
                                    Van een verjaardag tot een concert.
                                    Maak een evenement en nodig mensen uit.
                                </p>

                            </div>

                            <div class="col-auto">

                                <a href="#" class="btn btn-light">
                                    Evenement organiseren
                                </a>

                            </div>

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
</body>
</html>