

@extends('layouts.admin')

@section('content')
    <h3 class="fs-4 mb-3 fw-bold">Residents Info</h3>

    <div class="card shadow-sm border-0">
        {{-- Card  --}}
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-secondary">
                <i class="bi bi-people me-2"></i>Registered Users
            </h5>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success mb-3">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger mb-3">{{ session('error') }}</div>
            @endif

            {{-- Search & Filter Form --}}
            <form action="{{ route('admin.users') }}" method="GET" class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>

                        <input
                            type="text"
                            name="search"
                            class="form-control border-start-0 ps-0"
                            placeholder="Search ID, name, or email..."
                            value="{{ request('search') }}"
                            aria-label="Search users"
                        >
                    </div>
                </div>

                {{--  filter --}}
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-outline-primary">
                        Filter
                    </button>
                </div>

                <div class="col-md-2 d-grid">
                    <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
                        Clear
                    </a>
                </div>
            </form>

            {{-- Users table --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;">ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th style="width: 150px;">Joined Date</th>
                            <th style="width: 180px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td class="fw-bold">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>

                                <td>
                                    <div class="d-flex gap-2">
                                        <a
                                            href="{{ route('admin.users.edit', $user->id) }}"
                                            class="btn btn-sm btn-primary"
                                        >
                                            Edit
                                        </a>

                                        {{-- 
                                            Delete user
                                            
                                        --}}
                                        <form
                                            action="{{ route('admin.users.destroy', $user->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this user?');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            {{-- Empty  --}}
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
