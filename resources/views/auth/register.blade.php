<x-guest-layout>
    
    {{-- Header --}}
    <div class="text-center mb-4">
        <h3 class="fw-bold text-primary">Join the Community</h3>
        <p class="text-muted small">Create your resident account to get started.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label fw-bold small text-muted">Full Name</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-primary">
                    <i class="bi bi-person-fill"></i>
                </span>
                <input id="name" type="text" name="name" class="form-control border-start-0" 
                       value="{{ old('name') }}" required autofocus placeholder="Full Name">
            </div>
            <x-input-error :messages="$errors->get('name')" class="text-danger small mt-1" />
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-bold small text-muted">Email Address</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-primary">
                    <i class="bi bi-envelope-fill"></i>
                </span>
                <input id="email" type="email" name="email" class="form-control border-start-0" 
                       value="{{ old('email') }}" required placeholder="name@gmail.com">
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
                       required autocomplete="new-password" placeholder="Create a password">
            </div>
            <x-input-error :messages="$errors->get('password')" class="text-danger small mt-1" />
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-bold small text-muted">Confirm Password</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-primary">
                    <i class="bi bi-shield-lock-fill"></i>
                </span>
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control border-start-0" 
                       required placeholder="Confirm password">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger small mt-1" />
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm">
                <i class="bi me-2"></i>Register
            </button>
        </div>

        <div class="mt-4 text-center small">
            <span class="text-muted">Already have an account?</span>
            <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-primary ms-1">
                Log In
            </a>
        </div>
    </form>
</x-guest-layout>