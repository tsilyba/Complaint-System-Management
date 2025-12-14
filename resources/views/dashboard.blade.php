<x-app-layout>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-white border-bottom py-3">
                        <h4 class="mb-0 text-primary fw-bold">Dashboard</h4>
                    </div>

                    <div class="card-body p-5">
                        <h2 class="mb-3">Welcome, {{ Auth::user()->name }}!</h2>
                        
                        @if(Auth::user()->is_admin)
                            <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
                                <i class="bi bi-shield-lock-fill me-2" style="font-size: 1.2rem;"></i>
                                <div>
                                    <strong>Admin Access:</strong> You have administrator privileges.
                                    <a href="{{ route('admin.dashboard') }}" class="fw-bold text-danger ms-2">Go to Admin Panel &rarr;</a>
                                </div>
                            </div>
                        @endif

                        <p class="lead text-muted mb-4">
                            You are successfully logged in. Use the buttons below to report a new issue or track the status of your existing complaints.
                        </p>

                        <hr class="my-4">

                        <div class="d-flex gap-3 flex-wrap">
                            <a href="{{ route('complaints.create') }}" class="btn btn-primary btn-lg px-4 shadow-sm">
                                Lodge a New Complaint
                            </a>

                            <a href="{{ route('complaints.index') }}" class="btn btn-outline-primary btn-lg px-4 shadow-sm">
                                View My History
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

