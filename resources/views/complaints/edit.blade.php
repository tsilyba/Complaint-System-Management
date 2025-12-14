<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Complaint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Edit Complaint</h4>
                </div>
                <div class="card-body">
                    
                    <form action="{{ route('complaints.update', $complaint->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $complaint->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" value="{{ $complaint->address }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contact Number</label>
                            <input type="text" class="form-control" name="contact_number" value="{{ $complaint->contact_number }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Issue Type</label>
                            <select class="form-select" name="issue_type" required>
                                <option value="potholes" {{ $complaint->issue_type == 'potholes' ? 'selected' : '' }}>Potholes</option>
                                <option value="broken facilities" {{ $complaint->issue_type == 'broken facilities' ? 'selected' : '' }}>Broken Facilities</option>
                                <option value="garbage collection" {{ $complaint->issue_type == 'garbage collection' ? 'selected' : '' }}>Garbage Collection</option>
                                <option value="streetlights issue" {{ $complaint->issue_type == 'streetlights issue' ? 'selected' : '' }}>Streetlights Issue</option>
                                <option value="flooding" {{ $complaint->issue_type == 'flooding' ? 'selected' : '' }}>Flooding</option>
                                <option value="others" {{ $complaint->issue_type == 'others' ? 'selected' : '' }}>Others</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="4" required>{{ $complaint->description }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Current Photo</label><br>
                            @if($complaint->image_path)
                                <img src="{{ asset('storage/' . $complaint->image_path) }}" width="150" class="img-thumbnail mb-2">
                            @endif
                            <input class="form-control" type="file" name="photo">
                            <div class="form-text">Leave empty if you don't want to change the photo.</div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('complaints.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-warning">Update Complaint</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>