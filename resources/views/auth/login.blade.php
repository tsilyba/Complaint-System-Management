<x-guest-layout>
    
    {{-- Header Section --}}
    <div class="text-center mb-4">
        <h3 class="fw-bold text-primary">Welcome Back</h3>
        <p class="text-muted small">Please login to manage your complaints.</p>
    </div>

    {{-- Session Status --}}
    <x-auth-session-status class="mb-3 alert alert-success small shadow-sm" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label fw-bold small text-muted">Email Address</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-primary">
                    <i class="bi bi-envelope-fill"></i>
                </span>
                <input id="email" type="email" name="email" class="form-control border-start-0" 
                       value="{{ old('email') }}" required autofocus placeholder="name@example.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="text-danger small mt-1" />
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-bold small text-muted">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-primary">
                    <i class="bi bi-key-fill"></i>
                </span>
                <input id="password" type="password" name="password" class="form-control border-start-0" 
                       required autocomplete="current-password" placeholder="Enter your password">
            </div>
            <x-input-error :messages="$errors->get('password')" class="text-danger small mt-1" />
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label for="remember_me" class="form-check-label small text-muted">Remember me</label>
            </div>
            
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-decoration-none small fw-bold text-primary">
                    Forgot Password?
                </a>
            @endif
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm">
                <i class="bi bi-box-arrow-in-right me-2"></i>Log In
            </button>
        </div>

        <div class="mt-4 text-center small">
            <span class="text-muted">New to Kampung Sentosa?</span>
            <a href="{{ route('register') }}" class="text-decoration-none fw-bold text-primary ms-1">
                Create an Account
            </a>
        </div>
    </form>
</x-guest-layout>