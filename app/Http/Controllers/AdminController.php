<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\ComplaintFacade; // <--- The EAI Orchestrator
use App\Repositories\SQLComplaintRepo;
use App\Models\User;

class AdminController extends Controller
{
    protected $repo;
    protected $facade;

    // Dependency Injection: We inject the Repo and Facade here
    // This allows the Controller to be "dumb" (Decoupled)
    public function __construct(SQLComplaintRepo $repo, ComplaintFacade $facade)
    {
        $this->repo = $repo;
        $this->facade = $facade;
    }


    // Show Admin Dashboard with ALL complaints
   
        // Show Admin Dashboard with ALL complaints
    public function index()
    {
        // 1. Fetch data using your Repository
        $complaints = $this->repo->getAll(); 
        
        // 2. Calculate Analytics from the Collection (Fixes the Error)
        // Since we already have the data in $complaints, we can just count it here.
        $totalComplaints = $complaints->count();
        $pendingCount    = $complaints->where('status', 'Pending')->count();
        $inProgressCount = $complaints->where('status', 'In Progress')->count();
        $resolvedCount   = $complaints->where('status', 'Resolved')->count();

        // 3. Send ALL variables to the view
        return view('admin.dashboard', compact(
            'complaints', 
            'totalComplaints', 
            'pendingCount', 
            'inProgressCount', 
            'resolvedCount'
        ));
    }
    

    // Admin can update the status
    public function updateStatus(Request $request, $id)
    {
        // 1. Basic Input Validation (Controller's job)
        $request->validate([
            'status' => 'required|in:Pending,In Progress,Resolved'
        ]);

        // 2. Delegate to Facade (The EAI Magic)
        // OLD: $complaint->update(...)
        // NEW: The Facade handles the "Commit -> Notify" sequence
        $result = $this->facade->updateStatus($id, $request->status);

        if ($result) {
            return redirect()->back()->with('success', 'Status updated & Notification sent to Resident!');
        }

        return redirect()->back()->with('error', 'Failed to update status.');
    }

    public function users()
    {
        $users = User::where('is_admin', false)->get();
        return view('admin.users', compact('users'));
    }

// 4. COMPLAINT HISTORY PAGE (With Search & Filter Logic)
    public function complaints(Request $request)
    {
        // Start a query (We use the Model directly here for flexible filtering)
        $query = \App\Models\Complaint::with('user')->latest();

        // 1. Handle Search Box
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'LIKE', "%$search%")             // Search by ID
                  ->orWhere('description', 'LIKE', "%$search%")  // Search by Description
                  ->orWhere('issue_type', 'LIKE', "%$search%")   // Search by Issue Type
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'LIKE', "%$search%"); // Search by Resident Name
                  });
            });
        }

        // 2. Handle Status Dropdown
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Get the results (10 per page)
        $complaints = $query->paginate(10);

        // 4. Return the view with the filtered data
        return view('admin.complaints', compact('complaints'));
    }
     
}