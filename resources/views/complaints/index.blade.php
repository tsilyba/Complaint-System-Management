<x-app-layout>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Complaints History</h4>
                        <a href="{{ route('complaints.create') }}" class="btn btn-light btn-sm">+ New Complaint</a>
                    </div>
                    <div class="card-body">
                        
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                       <div class="card-body p-4">
                        
                        {{-- SEARCH & FILTER FORM --}}
                        <form action="{{ route('complaints.index') }}" method="GET" class="row g-3 mb-4">
                            
                            {{-- Search Input --}}
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-search text-muted"></i>
                                    </span>
                                    <input type="text" name="search" class="form-control border-start-0 ps-0" 
                                           placeholder="Search issue, description, or ID..." 
                                           value="{{ request('search') }}">
                                </div>
                            </div>

                            {{-- Status Filter --}}
                            <div class="col-md-4">
                                <select name="status" class="form-select">
                                    <option value="">All Statuses</option>
                                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="Resolved" {{ request('status') == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                </select>
                            </div>

                            {{-- Filter Buttons --}}
                            <div class="col-md-2 d-grid">
                                <button type="submit" class="btn btn-outline-primary">Filter</button>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Photo</th>
                                        <th>Issue Info</th>
                                        <th>Description</th>
                                        <th>Contact</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($complaints as $complaint)
                                    <tr>
                                        <td class="align-middle">{{ $complaint->id }}</td>
                                        <td style="width: 100px;">
                                            @if($complaint->image_path)
                                                <img src="{{ asset('storage/' . $complaint->image_path) }}" class="img-thumbnail" style="height: 80px; width: 80px; object-fit: cover;">
                                            @else
                                                <span class="text-muted">No Img</span>
                                            @endif
                                        </td>

                                        <td>
                                            <strong>{{ ucfirst($complaint->issue_type) }}</strong><br>
                                            <small class="text-muted">{{ $complaint->address }}</small><br>
                                            <small class="text-muted">By: {{ $complaint->name }}</small>
                                        </td>

                                        <td>{{ Str::limit($complaint->description, 50) }}</td>

                                        <td>{{ $complaint->contact_number }}</td>

                                        <td>
                                            @if($complaint->status == 'Pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif($complaint->status == 'In Progress')
                                                <span class="badge bg-info text-dark">In Progress</span>
                                            @elseif($complaint->status == 'Resolved')
                                                <span class="badge bg-success">Resolved</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $complaint->status }}</span>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('complaints.edit', $complaint->id) }}" class="btn btn-sm btn-primary">
                                                    Edit
                                                </a>

                                                <form action="{{ route('complaints.destroy', $complaint->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            No complaints found. <a href="{{ route('complaints.create') }}">Lodge one now?</a>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>