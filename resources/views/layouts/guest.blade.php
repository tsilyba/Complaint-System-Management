<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Kampung Sentosa') }}</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    {{-- YOUR BROWN THEME CSS --}}
    <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">

    <style>
        body {
            background-color: #f8f9fa; /* Light gray background */
            padding-top: 80px; /* Space for fixed navbar */
        }
    </style>
</head>
<body>

    {{-- STATIC NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
                <i class="bi bi-buildings-fill me-2"></i>Kampung Sentosa
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item me-2">
                        <a href="{{ route('login') }}" class="btn btn-link text-decoration-none text-dark fw-bold {{ request()->routeIs('login') ? 'text-primary' : '' }}">Log in</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn {{ request()->routeIs('register') ? 'btn-primary text-white' : 'btn-outline-primary' }} fw-bold px-4 rounded-pill">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <div class="container d-flex flex-column justify-content-center align-items-center min-vh-100 py-5">
        

        {{-- Slot for Login/Register Forms --}}
        <div class="card shadow-sm border-0 p-4" style="width: 100%; max-width: 450px;">
            {{ $slot }}
        </div>
    </div>

</body>
</html>