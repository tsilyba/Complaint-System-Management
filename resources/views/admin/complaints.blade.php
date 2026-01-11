@extends('layouts.admin')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Complaint History</h3>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-secondary"><i class="bi bi-table me-2"></i>All Complaints</h5>
        </div>

        <div class="card-body">
            
            {{-- ========================================================= --}}
            {{-- SEARCH & FILTER FORM                                      --}}
            {{-- ========================================================= --}}
            <form action="{{ route('admin.complaints') }}" method="GET" class="row g-3 mb-4">
                
                {{-- 1. Search Box --}}
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0" 
                               placeholder="Search ID, Resident Name, or Issue..." 
                               value="{{ request('search') }}">
                    </div>
                </div>

                {{-- 2. Status Filter --}}
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Resolved" {{ request('status') == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                    </select>
                </div>

                {{-- 3. Action Buttons (Filter & PDF) --}}
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
                    
                    {{-- NEW PDF EXPORT BUTTON --}}
                    {{-- Note: ensure the route 'admin.complaints.exportPdf' exists --}}
                    <a href="{{ route('admin.complaints.exportPdf', request()->query()) }}" class="btn btn-danger w-100">
                         <i class="bi bi-file-earmark-pdf"></i> PDF
                    </a>
                </div>
            </form>
            {{-- ========================================================= --}}

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Complaint ID</th>
                            <th>Resident Name</th>
                            <th>Issue Type</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($complaints as $complaint)
                        <tr>
                            <td class="ps-4 fw-bold">#{{ $complaint->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="fw-bold">{{ $complaint->user->name ?? 'Unknown' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-secondary mb-1">{{ $complaint->issue_type }}</span>
                            </td>
                            <td>
                                <span class="text-muted small d-inline-block text-truncate" style="max-width: 250px;">
                                    {{ $complaint->description }}
                                </span>
                            </td>
                            <td>
                                @if($complaint->status == 'Resolved')
                                    <span class="badge bg-success-subtle text-success border border-success px-2 py-1 rounded-pill">Resolved</span>
                                @elseif($complaint->status == 'In Progress')
                                    <span class="badge bg-warning-subtle text-warning border border-warning px-2 py-1 rounded-pill">In Progress</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger px-2 py-1 rounded-pill">Pending</span>
                                @endif
                            </td>
                            <td>
                                {{-- ACTION BUTTON (Status Update) --}}
                                <form action="{{ route('admin.updateStatus', $complaint->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="input-group input-group-sm" style="width: 160px;">
                                        <select name="status" class="form-select border-secondary shadow-sm">
                                            <option value="Pending" {{ $complaint->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="In Progress" {{ $complaint->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="Resolved" {{ $complaint->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                        </select>
                                        <button class="btn btn-primary" type="submit" title="Save Status">
                                            <i class="bi bi-save"></i>
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                No complaints found matching your filters.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination Links --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $complaints->withQueryString()->links() }}
            </div>

        </div>
    </div>

@endsection