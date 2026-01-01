<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                {{-- CARD CONTAINER --}}
                <div class="card shadow-sm border-0">
                    {{-- HEADER --}}
                    <div class="card-header bg-warning text-dark py-3">
                        <h4 class="mb-0 fw-bold">
                            <i class="bi bi-pencil-fill me-2"></i>Edit Complaint #{{ $complaint->id }}
                        </h4>
                    </div>

                    {{-- BODY --}}
                    <div class="card-body p-4">
                        
                        {{-- Validation Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('complaints.update', $complaint->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT') 

                            {{-- 1. FULL NAME --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Full Name</label>
                                <input type="text" class="form-control bg-light" name="name" value="{{ $complaint->name }}" readonly>
                                <div class="form-text">Reporter name cannot be changed.</div>
                            </div>

                            {{-- 2. ADDRESS --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Address</label>
                                <input type="text" class="form-control" name="address" value="{{ $complaint->address }}" required>
                            </div>

                            {{-- 3. CONTACT NUMBER --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Contact Number</label>
                                <input type="text" class="form-control" name="contact_number" value="{{ $complaint->contact_number }}" required>
                            </div>

                            {{-- 4. ISSUE TYPE --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Issue Type</label>
                                <select class="form-select" name="issue_type" required>
                                    <option value="potholes" {{ $complaint->issue_type == 'potholes' ? 'selected' : '' }}>Potholes</option>
                                    <option value="broken facilities" {{ $complaint->issue_type == 'broken facilities' ? 'selected' : '' }}>Broken Facilities</option>
                                    <option value="garbage collection" {{ $complaint->issue_type == 'garbage collection' ? 'selected' : '' }}>Garbage Collection</option>
                                    <option value="streetlights issue" {{ $complaint->issue_type == 'streetlights issue' ? 'selected' : '' }}>Streetlights Issue</option>
                                    <option value="flooding" {{ $complaint->issue_type == 'flooding' ? 'selected' : '' }}>Flooding</option>
                                    <option value="others" {{ $complaint->issue_type == 'others' ? 'selected' : '' }}>Others</option>
                                </select>
                            </div>

                            {{-- 5. DESCRIPTION --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <textarea class="form-control" name="description" rows="5" required>{{ $complaint->description }}</textarea>
                            </div>

                            {{-- 6. PHOTO EVIDENCE --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold">Photo Evidence</label>
                                <div class="p-3 bg-light rounded border mb-2">
                                    @if($complaint->image_path)
                                        <p class="small text-muted mb-2">Current Photo:</p>
                                        <img src="{{ asset('storage/' . $complaint->image_path) }}" class="img-thumbnail" style="max-height: 200px;">
                                    @else
                                        <p class="text-muted small mb-0">No photo currently attached.</p>
                                    @endif
                                </div>
                                
                                <label class="form-label small text-muted">Upload New Photo (Optional)</label>
                                <input class="form-control" type="file" name="photo">
                                <div class="form-text">Leave empty if you don't want to change the photo.</div>
                            </div>

                            {{-- ACTIONS --}}
                            <div class="d-flex justify-content-between pt-3 border-top">
                                <a href="{{ route('dashboard') }}" class="btn btn-light text-muted">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-warning px-4 shadow-sm">
                                    Update Complaint
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>