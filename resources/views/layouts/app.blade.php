<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts & Styles -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">

    <!-- Bootstrap & Chart.js -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

    </style>
</head>
<body>
 <div id="app">
    <nav class="navbar navbar-expand-md navbar-dark shadow-sm fixed-top" style="background: rgb(0, 0, 255);">
        <div class="container position-relative d-flex align-items-center justify-content-between">
            <!-- Logo Kiri -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ url('/image/logo3.png') }}" alt="Logo" width="60"/>
            </a>

            <!-- Toggler Kanan -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu Tengah -->
            <div class="position-absolute top-50 start-50 translate-middle d-none d-md-block">
                <ul class="navbar-nav flex-row gap-4 fw-bold text-center">
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('monitoring.index') ? 'active' : '' }}" href="{{ route('monitoring.index') }}">Monitoring</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('riwayat') ? 'active' : '' }}" href="{{ route('riwayat') }}">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('notifikasi') ? 'active' : '' }}" href="{{ route('notifikasi') }}">Riwayat</a>
                    </li>
                </ul>
            </div>

            <!-- Collapse Menu (Mobile & Login/User Section) -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Menu Tengah untuk Mobile -->
                <ul class="navbar-nav fw-bold text-center d-md-none">
                    <li class="nav-item"><a class="nav-link text-white" href="{{ route('home') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="{{ route('monitoring.index') }}">Monitoring</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="{{ route('riwayat') }}">Berita</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="{{ route('notifikasi') }}">Riwayat</a></li>
                </ul>

                <!-- Login / User Menu -->
                <ul class="navbar-nav ms-auto text-center">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item"><a class="nav-link text-white" href="{{ route('login') }}">Login</a></li>
                        @endif
                        @if (Route::has('register'))
                            <li class="nav-item"><a class="nav-link text-white" href="{{ route('register') }}">Register</a></li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4 mt-5">
        @yield('content')
    </main>
</div>


   <footer class="footer">
    <div class="waves">
        <div class="wave" id="wave1"></div>
        <div class="wave" id="wave2"></div>
        <div class="wave" id="wave3"></div>
        <div class="wave" id="wave4"></div>
    </div>
    <ul class="social-icon">
        <li class="social-icon__item"><a class="social-icon__link" href="#"><ion-icon name="logo-facebook"></ion-icon></a></li>
        <li class="social-icon__item"><a class="social-icon__link" href="#"><ion-icon name="logo-twitter"></ion-icon></a></li>
        <li class="social-icon__item"><a class="social-icon__link" href="#"><ion-icon name="logo-linkedin"></ion-icon></a></li>
        <li class="social-icon__item"><a class="social-icon__link" href="#"><ion-icon name="logo-instagram"></ion-icon></a></li>
    </ul>
    <ul class="menu">
        <li class="menu__item"><a class="menu__link" href="#">Home</a></li>
        <li class="menu__item"><a class="menu__link" href="#">About</a></li>
        <li class="menu__item"><a class="menu__link" href="#">Services</a></li>
        <li class="menu__item"><a class="menu__link" href="#">Team</a></li>
        <li class="menu__item"><a class="menu__link" href="#">Contact</a></li>
    </ul>
    <p>&copy;2024 JAYLA TECH.ID</p>
    <img src="{{ url('/image/logo3.png') }}" alt="image" width="80"/>
</footer>


    {{-- Script stack for pages --}}
    @stack('scripts')
</body>
</html>
