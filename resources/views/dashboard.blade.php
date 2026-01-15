<x-app-layout>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-white border-bottom py-3">
                        <h4 class="mb-0 text-primary fw-bold">Dashboard</h4>
                    </div>

                    <div class="card-body p-5">
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                       
        <div class="row mb-5 align-items-center">
            <div class="col-md-8">
                <h2 class="fw-bold text-primary mb-1">Welcome back, {{ Auth::user()->name }}!</h2>
                <p class="text-muted lead mb-0">
                    Here is the status of your reported issues in Kampung Sentosa.
                </p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('complaints.create') }}" class="btn btn-primary btn-lg shadow-sm px-4">
                    <i class="bi bi-plus-lg me-2"></i>Lodge New Complaint
                </a>
            </div>
        </div>

        <div class="row g-4 mb-5">
            {{-- Card 1: Active Issues --}}
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 border-start border-4 border-warning">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="text-muted mb-0 fw-bold text-uppercase">In Progress</h6>
                        </div>
                        @php
                            // Count Pending + In Progress
                            $activeCount = \App\Models\Complaint::where('user_id', Auth::id())
                                            ->whereIn('status', ['Pending', 'In Progress'])->count();
                        @endphp
                        <h2 class="display-6 fw-bold mb-0">{{ $activeCount }}</h2>
                        <small class="text-muted">Issues currently being resolved</small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 border-start border-4 border-success">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="text-muted mb-0 fw-bold text-uppercase">Resolved</h6>
                        </div>
                        @php
                            $resolvedCount = \App\Models\Complaint::where('user_id', Auth::id())
                                            ->where('status', 'Resolved')->count();
                        @endphp
                        <h2 class="display-6 fw-bold mb-0">{{ $resolvedCount }}</h2>
                        <small class="text-muted">Successfully closed cases</small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 border-start border-4 border-primary">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="text-muted mb-0 fw-bold text-uppercase">Total History</h6>
                        </div>
                        @php
                            $totalCount = \App\Models\Complaint::where('user_id', Auth::id())->count();
                        @endphp
                        <h2 class="display-6 fw-bold mb-0">{{ $totalCount }}</h2>
                        <small class="text-muted">Lifetime reports submitted</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- view history button -->
        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('complaints.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-clock-history me-2"></i>View Full Complaint History
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-clock-history me-2"></i>Recent Activity</h5>
                <a href="{{ route('complaints.index') }}" class="btn btn-sm btn-outline-primary">View Full History</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4">Issue</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $recentComplaints = \App\Models\Complaint::where('user_id', Auth::id())
                                                    ->latest()
                                                    ->take(3)
                                                    ->get();
                            @endphp

                            @forelse($recentComplaints as $complaint)
                            <tr>
                                <td class="ps-4">
                                    
                                    <span class="d-block fw-bold text-dark">{{ $complaint->issue_type }}</span>
                                    <small class="text-muted">{{ Str::limit($complaint->description, 40) }}</small>
                                </td>
                                <td class="text-muted small">
                                    {{ $complaint->created_at->format('d M Y') }}
                                </td>
                                <td>
                                    @if($complaint->status == 'Resolved')
                                        <span class="badge bg-success-subtle text-success border border-success px-3 rounded-pill">Resolved</span>
                                    @elseif($complaint->status == 'In Progress')
                                        <span class="badge bg-warning-subtle text-warning border border-warning px-3 rounded-pill">In Progress</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary px-3 rounded-pill">Pending</span>
                                    @endif
                                </td>
                                
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                    You haven't submitted any complaints yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>

                        

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>