<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lodge Complaint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Lodge a Complaint</h4>
                </div>
                <div class="card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required placeholder="Enter your full name">
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required placeholder="Location of the issue">
                        </div>

                        <div class="mb-3">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="tel" class="form-control" id="contact_number" name="contact_number" required placeholder="e.g. 012-3456789">
                        </div>

                        <div class="mb-3">
                            <label for="issue_type" class="form-label">Issue Type</label>
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

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required placeholder="Describe the problem in detail..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Upload Photo Evidence</label>
                            <input class="form-control" type="file" id="photo" name="photo" accept="image/*" required>
                            <div class="form-text">Supported formats: JPG, PNG. Max size: 2MB.</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Submit Complaint</button>
                        </div>

                    </form>
                </div>
            </div>
            
            <div class="text-center mt-3">
                <a href="/dashboard" class="text-decoration-none">Back to Dashboard</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>