<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                {{-- Container --}}
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0 fw-bold">
                            <i class="bi bi-pencil-square me-2"></i>Lodge a Complaint
                        </h4>
                    </div>

                    <div class="card-body p-4">
                        @if(session('success'))
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- FULL NAME--}}
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Full Name</label>
                                <input type="text" class="form-control bg-light" id="name" name="name" 
                                       value="{{ Auth::user()->name }}" readonly>
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            </div>

                            {{-- ADDRESS --}}
                            <div class="mb-3">
                                <label for="address" class="form-label fw-bold">Address</label>
                                <input type="text" class="form-control" id="address" name="address" required placeholder="Location of the issue">
                            </div>

                            {{-- CONTACT NUMBER --}}
                            <div class="mb-3">
                                <label for="contact_number" class="form-label fw-bold">Contact Number</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="contact_number" 
                                    name="contact_number" 
                                    required 
                                    pattern="\d{11}" 
                                    minlength="11" 
                                    maxlength="11"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    placeholder="e.g. 01234567890">
                        
                            </div>

                            {{-- ISSUE TYPE --}}
                            <div class="mb-3">
                                <label for="issue_type" class="form-label fw-bold">Issue Type</label>
                                <select class="form-select" id="issue_type" name="issue_type" required>
                                    <option value="" selected disabled>Select an issue...</option>
                                    <option value="potholes">Potholes</option>
                                    <option value="broken facilities">Broken Facilities</option>
                                    <option value="garbage collection">Garbage Collection</option>
                                    <option value="streetlights issue">Streetlights Issue</option>
                                    <option value="flooding">Flooding</option>
                                    <option value="others">Others</option>
                                </select>
                            </div>

                            {{-- DESCRIPTION --}}
                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="5" required placeholder="Describe the problem in detail..."></textarea>
                            </div>

                            {{-- PHOTO EVIDENCE --}}
                            <div class="mb-4">
                                <label for="photo" class="form-label fw-bold">Upload Photo Evidence</label>
                                <input class="form-control" type="file" id="photo" name="photo" accept="image/*">
                                <div class="form-text">Supported formats: JPG, PNG. Max size: 2MB.</div>
                            </div>

                            {{-- BUTTONS --}}
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                                    Submit Complaint
                                </button>
                                <a href="{{ route('dashboard') }}" class="btn btn-light text-muted">
                                    Cancel
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>