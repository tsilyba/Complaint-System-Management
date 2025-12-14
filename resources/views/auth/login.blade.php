<x-guest-layout>
    <h3 class="text-center mb-4">Resident Login</h3>

    @if (session('status'))
        <div class="alert alert-success mb-3">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input id="email" type="email" name="email" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password" class="form-control" required>
        </div>

        <div class="form-check mb-3">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label for="remember_me" class="form-check-label">Remember me</label>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">Log in</button>
        </div>

        <div class="mt-3 text-center">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-muted small d-block mb-2">Forgot your password?</a>
            @endif
            <a href="{{ route('register') }}" class="text-muted small">Don't have an account? Register</a>
        </div>
    </form>
</x-guest-layout>
