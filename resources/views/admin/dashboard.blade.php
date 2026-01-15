@extends('layouts.admin')

@section('content')

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Overview</h3>
        </div>
        <div class="text-end">
            <span class="badge bg-light text-dark border px-3 py-2 shadow-sm">
                <i class="bi bi-calendar3 me-2"></i>{{ now()->format('d M Y') }}
            </span>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4 col-xl-3">
            <div class="row g-3">
                
                {{-- Card 1: Total --}}
                <div class="col-12">
                    <div class="card border-0 shadow-sm border-start border-4 border-primary h-100">
                        <div class="card-body d-flex align-items-center justify-content-between p-4">
                            <div>
                                <h6 class="text-uppercase text-muted small fw-bold mb-1">Total Reports</h6>
                                <h2 class="text-primary fw-bold mb-0">{{ $totalComplaints }}</h2>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                                <i class="bi bi-folder2-open fs-4 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Pending --}}
                <div class="col-12">
                    <div class="card border-0 shadow-sm border-start border-4 border-danger h-100">
                        <div class="card-body d-flex align-items-center justify-content-between p-4">
                            <div>
                                <h6 class="text-uppercase text-muted small fw-bold mb-1">Pending</h6>
                                <h2 class="text-danger fw-bold mb-0">{{ $pendingCount }}</h2>
                            </div>
                            <div class="bg-danger bg-opacity-10 p-3 rounded-circle">
                                <i class="bi bi-exclamation-circle fs-4 text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 3: In Progress --}}
                <div class="col-12">
                    <div class="card border-0 shadow-sm border-start border-4 border-warning h-100">
                        <div class="card-body d-flex align-items-center justify-content-between p-4">
                            <div>
                                <h6 class="text-uppercase text-muted small fw-bold mb-1">In Progress</h6>
                                <h2 class="text-warning fw-bold mb-0">{{ $inProgressCount }}</h2>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                                <i class="bi bi-hourglass-split fs-4 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 4: Resolved --}}
                <div class="col-12">
                    <div class="card border-0 shadow-sm border-start border-4 border-success h-100">
                        <div class="card-body d-flex align-items-center justify-content-between p-4">
                            <div>
                                <h6 class="text-uppercase text-muted small fw-bold mb-1">Resolved</h6>
                                <h2 class="text-success fw-bold mb-0">{{ $resolvedCount }}</h2>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                                <i class="bi bi-check-circle fs-4 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-lg-8 col-xl-9">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-0 d-flex align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pie-chart-fill me-2 text-primary"></i>Status Distribution</h5>
                </div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center" style="min-height: 400px;">
                    <div style="width: 100%; max-width: 500px;">
                        <canvas id="statusChart"></canvas>
                    </div>
                    <p class="text-muted small mt-4 text-center">
                        <span class="fw-bold text-dark">{{ $pendingCount }} pending tasks</span> require attention.
                    </p>
                </div>
            </div>
        </div>

    </div>

    <script>
        const ctx = document.getElementById('statusChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'In Progress', 'Resolved'],
                datasets: [{
                    data: [{{ $pendingCount }}, {{ $inProgressCount }}, {{ $resolvedCount }}],
                    backgroundColor: [
                        '#dc3545', // Red
                        '#ffc107', // Yellow
                        '#198754'  // Green
                    ],
                    borderWidth: 0,
                    hoverOffset: 20
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, 
                cutout: '75%', 
                plugins: {
                    legend: {
                        position: 'right', 
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: { size: 14 }
                        }
                    }
                }
            }
        });
    </script>
@endsection