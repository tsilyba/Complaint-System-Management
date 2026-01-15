<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <br>
    <title>Kampung Sentosa Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
</head>
<body>

    {{-- NAVIGATION BAR --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#">
                <i class="bi bi-buildings-fill me-2"></i>Kampung Sentosa
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ url('/dashboard') }}" class="btn btn-outline-primary fw-bold">Go to Dashboard</a>
                            </li>
                            
                        @else
                            <li class="nav-item me-2">
                                <a href="{{ route('login') }}" class="btn btn-link text-decoration-none text-dark fw-bold">Log in</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="btn btn-primary fw-bold px-4 rounded-pill">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    {{-- HERO SECTION --}}
    <header class="hero-section text-center mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Welcome to Kampung Sentosa</h1>
                    <p class="lead mb-5">A smarter way to manage our community. Lodge complaints, track progress, and stay updated with the latest community news in one secure portal.</p>
                    
                </div>
            </div>
        </div>
    </header>

    {{-- FEATURES SECTION --}}
    <section class="container mb-5">
        <div class="row g-4 text-center">
            
            {{-- Feature 1 --}}
            <div class="col-md-4">
                <div class="card feature-card h-100 shadow-sm p-4">
                    <div class="card-body">
                        <div class="icon-box">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Lodge Complaints</h4>
                        <p class="text-muted">Easily report issues like potholes, streetlights, or drainage problems directly to the administration.</p>
                    </div>
                </div>
            </div>

            {{-- Feature 2 --}}
            <div class="col-md-4">
                <div class="card feature-card h-100 shadow-sm p-4">
                    <div class="card-body">
                        <div class="icon-box">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Real-time Tracking</h4>
                        <p class="text-muted">Track the status of your reports from "Pending" to "Resolved" with our transparent dashboard.</p>
                    </div>
                </div>
            </div>

            {{-- Feature 3 --}}
            <div class="col-md-4">
                <div class="card feature-card h-100 shadow-sm p-4">
                    <div class="card-body">
                        <div class="icon-box">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Secure & Private</h4>
                        <p class="text-muted">Your data is secure with us. We ensure that your personal information and reports are handled with care.</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-white py-4 mt-auto border-top">
        <div class="container text-center">
            <p class="text-muted mb-0">&copy; {{ date('Y') }} Kampung Sentosa Management System. All rights reserved.</p>
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>