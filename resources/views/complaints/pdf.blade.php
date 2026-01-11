<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Complaint Report Dashboard</title>
    <style>
        /* BASE STYLES */
        body {
            font-family: sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }

        /* HEADER */
        .header {
            background-color: #1e3a8a;
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            text-transform: uppercase;
        }

        .header .subtitle {
            font-size: 14px;
            opacity: 0.9;
            margin-top: 5px;
        }

        /* METRICS */
        .metrics-table {
            width: 100%;
            margin: 30px 0;
            border-collapse: separate;
            border-spacing: 15px;
        }

        .metric-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .metric-value {
            font-size: 32px;
            font-weight: bold;
            margin: 0;
            display: block;
        }

        .metric-label {
            font-size: 10px;
            text-transform: uppercase;
            color: #64748b;
            margin-top: 5px;
            display: block;
        }

        /* BORDERS FOR CARDS */
        .border-blue {
            border-left: 5px solid #3b82f6;
        }

        .border-yellow {
            border-left: 5px solid #f59e0b;
        }

        .border-purple {
            border-left: 5px solid #8b5cf6;
        }

        .border-green {
            border-left: 5px solid #10b981;
        }

        /* CHART SECTION */
        .section-title {
            font-size: 16px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
            margin: 30px 0 20px;
            font-weight: bold;
        }

        .chart-table {
            width: 100%;
            font-size: 12px;
            margin-bottom: 30px;
        }

        .chart-label {
            width: 30%;
            padding-right: 10px;
            text-align: right;
        }

        .chart-bar-cell {
            width: 70%;
        }

        .bar-container {
            background: #e2e8f0;
            height: 20px;
            border-radius: 4px;
            width: 100%;
        }

        .bar-fill {
            height: 100%;
            background-color: #3b82f6;
            border-radius: 4px;
            line-height: 20px;
            text-align: right;
            color: white;
            padding-right: 5px;
            font-size: 10px;
        }

        /* DATA TABLE */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .data-table th {
            background-color: #1e3a8a;
            color: white;
            padding: 10px;
            text-align: left;
        }

        /* UPDATED: Added vertical-align: top for multi-line addresses */
        .data-table td {
            border-bottom: 1px solid #e2e8f0;
            padding: 10px;
            vertical-align: top;
        }

        .data-table tr {
            page-break-inside: avoid;
        }

        /* STATUS BADGES */
        .badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
        }

        .badge-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-in-progress {
            background: #ede9fe;
            color: #5b21b6;
        }

        .badge-resolved {
            background: #d1fae5;
            color: #065f46;
        }

        .footer-note {
            text-align: center;
            font-size: 10px;
            color: #64748b;
            /* Muted gray color */
            margin-top: 40px;
            font-style: italic;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
        }
    </style>
</head>

<body>

    {{-- 1. PHP LOGIC --}}
    @php
    $total = $complaints->count();
    $pending = $complaints->where('status', 'Pending')->count();
    $inProgress = $complaints->where('status', 'In Progress')->count();
    $resolved = $complaints->where('status', 'Resolved')->count();

    // Chart Data (Unchanged as requested)
    $issues = $complaints->groupBy('issue_type')->map->count()->sortDesc();
    $maxIssueCount = $issues->max() ?: 1;
    @endphp

    {{-- 2. HEADER --}}
    <div class="header">
        <h1>Overall Complaint Report</h1>
        <div class="subtitle">Kampung Sentosa Residency</div>
        <div class="subtitle">{{ now()->format('F Y') }}</div>
    </div>

    {{-- 3. METRICS --}}
    <table class="metrics-table">
        <tr>
            <td width="25%">
                <div class="metric-card border-blue">
                    <span class="metric-value">{{ $total }}</span>
                    <span class="metric-label">Total Complaints</span>
                </div>
            </td>
            <td width="25%">
                <div class="metric-card border-yellow">
                    <span class="metric-value">{{ $pending }}</span>
                    <span class="metric-label">Pending</span>
                </div>
            </td>
            <td width="25%">
                <div class="metric-card border-purple">
                    <span class="metric-value">{{ $inProgress }}</span>
                    <span class="metric-label">In Progress</span>
                </div>
            </td>
            <td width="25%">
                <div class="metric-card border-green">
                    <span class="metric-value">{{ $resolved }}</span>
                    <span class="metric-label">Resolved</span>
                </div>
            </td>
        </tr>
    </table>

    {{-- 4. CHART SECTION (UNCHANGED) --}}
    <div class="section-title">Complaints by Issue Category</div>

    <table class="chart-table">
        @foreach($issues as $type => $count)
        @php
        $width = ($count / $maxIssueCount) * 100;
        @endphp
        <tr>
            <td class="chart-label"><strong>{{ ucfirst($type) }}</strong></td>
            <td class="chart-bar-cell">
                <div class="bar-container">
                    <div class="bar-fill" style="width: {{ $width }}%;">
                        {{ $count }}
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </table>

    {{-- 5. DETAILED DATA TABLE (UPDATED) --}}
    <div class="section-title">Detailed Complaint Records</div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="15%">Reporter</th>
                <th width="20%">Location</th>
                <th width="12%">Issue</th>
                <th width="20%">Description</th>
                <th width="15%">Timeline</th> {{-- NEW COLUMN --}}
                <th width="13%">Status</th>
            </tr>
        </thead>
        <tbody>
            {{-- SORTING LOGIC: Pending (1) -> In Progress (2) -> Resolved (3) --}}
            @forelse($complaints->sortBy(function($query) {
            return match($query->status) {
            'Pending' => 1,
            'In Progress' => 2,
            'Resolved' => 3,
            default => 4,
            };
            }) as $complaint)
            <tr>
                {{-- ID --}}
                <td><strong>#{{ $complaint->id }}</strong></td>

                {{-- Reporter Details (Combined) --}}
                <td>
                    <strong>{{ $complaint->name ?? $complaint->user->name ?? 'Guest' }}</strong><br>
                    <span style="font-size: 9px; color: #64748b; margin-top: 4px; display: block;">
                        {{ $complaint->contact_number ?? '-' }}
                    </span>
                </td>

                {{-- Location --}}
                <td>
                    <span style="font-size: 10px; line-height: 1.3;">
                        {{ $complaint->address ?? 'No address provided' }}
                    </span>
                </td>

                {{-- Issue Type --}}
                <td>{{ ucfirst($complaint->issue_type) }}</td>

                {{-- Description --}}
                <td style="color: #475569; font-style: italic;">
                    {{ Str::limit($complaint->description, 50) }}
                </td>

                {{-- Timeline (NEW: Created_at & Updated_at) --}}
                <td>
                    <div style="font-size: 10px; margin-bottom: 3px;">
                        <span style="color: #64748b;">In:</span>
                        {{ $complaint->created_at ? $complaint->created_at->format('d M Y') : '-' }}
                    </div>
                    <div style="font-size: 10px;">
                        <span style="color: #64748b;">Upd:</span>
                        {{ $complaint->updated_at ? $complaint->updated_at->format('d M Y') : '-' }}
                    </div>
                </td>

                {{-- Status --}}
                <td>
                    @php
                    $badgeClass = match($complaint->status) {
                    'Pending' => 'badge-pending',
                    'In Progress' => 'badge-in-progress',
                    'Resolved' => 'badge-resolved',
                    default => '',
                    };
                    @endphp
                    <span class="badge {{ $badgeClass }}">
                        {{ $complaint->status }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 20px;">No records found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-note">
        This is a computer generated document. No signature is required.
    </div>

</body>

</html>