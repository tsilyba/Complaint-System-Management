<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kampung Sentosa</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<div class="d-flex" id="wrapper">
    
    <div class="sidebar border-end" id="sidebar-wrapper">
        
        <div class="sidebar-heading text-center py-4 text-uppercase border-bottom border-secondary">
            Kampung Sentosa
        </div>
        
        <div class="list-group list-group-flush my-3">
            {{-- DASHBOARD --}}
            <a href="{{ route('admin.dashboard') }}" 
               class="list-group-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a>

            {{-- COMPLAINT HISTORY --}}
            <a href="{{ route('admin.complaints') }}" 
               class="list-group-item {{ request()->routeIs('admin.complaints') ? 'active' : '' }}">
                <i class="bi bi-list-task me-2"></i>Complaint History
            </a>

            {{-- RESIDENTS INFO --}}
            <a href="{{ route('admin.users') }}" 
               class="list-group-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <i class="bi bi-people me-2"></i>Residents Info
            </a>
            
            <form method="POST" action="{{ route('logout') }}" class="mt-4 px-3">
                @csrf
                <button type="submit" class="btn btn-outline-warning w-100 fw-bold">
                    <i class="bi bi-box-arrow-left me-2"></i>Log Out
                </button>
            </form>
        </div>
    </div>

    {{-- PAGE CONTENT --}}
    <div id="page-content-wrapper">
        
        <nav class="navbar navbar-expand-lg navbar-dark border-bottom shadow-sm px-4 py-3">
            <div class="d-flex align-items-center">
                <button class="btn btn-outline-light btn-sm me-3 d-md-none" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <h4 class="m-0 fw-bold">Admin Portal</h4>
            </div>
        </nav>

        <div class="container-fluid px-4 py-4">
            @yield('content')
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    window.addEventListener('DOMContentLoaded', event => {
        const sidebarToggle = document.body.querySelector('#sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', event => {
                event.preventDefault();
                document.body.classList.toggle('sb-sidenav-toggled');
                
                const wrapper = document.getElementById('wrapper');
                wrapper.classList.toggle('toggled');
            });
        }
    });
</script>

</body>
</html>