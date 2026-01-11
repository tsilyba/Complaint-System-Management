<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Complaint; // Imported for direct querying in reports
use App\Facades\ComplaintFacade; 
use App\Repositories\SQLComplaintRepo;
use Barryvdh\DomPDF\Facade\Pdf; // <--- 1. NEW IMPORT

class AdminController extends Controller
{
    protected $repo;
    protected $facade;

    public function __construct(SQLComplaintRepo $repo, ComplaintFacade $facade)
    {
        $this->repo = $repo;
        $this->facade = $facade;
    }

    // Show Admin Dashboard with ALL complaints & Analytics
    public function index()
    {
        $complaints = $this->repo->getAll(); 
        
        $totalComplaints = $complaints->count();
        $pendingCount    = $complaints->where('status', 'Pending')->count();
        $inProgressCount = $complaints->where('status', 'In Progress')->count();
        $resolvedCount   = $complaints->where('status', 'Resolved')->count();

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
        $request->validate([
            'status' => 'required|in:Pending,In Progress,Resolved'
        ]);

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
        $query = Complaint::with('user')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'LIKE', "%$search%")             
                  ->orWhere('description', 'LIKE', "%$search%")  
                  ->orWhere('issue_type', 'LIKE', "%$search%")   
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'LIKE', "%$search%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $complaints = $query->paginate(10);

        return view('admin.complaints', compact('complaints'));
    }
    
    // 5. NEW EXPORT PDF METHOD
    public function exportPdf(Request $request)
    {
        // Start Query (Same as complaints method)
        $query = Complaint::with('user')->latest();

        // 1. Re-apply Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'LIKE', "%$search%")             
                  ->orWhere('description', 'LIKE', "%$search%")  
                  ->orWhere('issue_type', 'LIKE', "%$search%")   
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'LIKE', "%$search%");
                  });
            });
        }

        // 2. Re-apply Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Get All Data (Use get() instead of paginate())
        $complaints = $query->get();

        // 4. Generate PDF
        // You can reuse the 'complaints.pdf' view we created earlier
        $pdf = Pdf::loadView('complaints.pdf', compact('complaints'));
        
        return $pdf->download('admin_complaints_report.pdf');
    }

    // 6. User Management
    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user && !$user->is_admin) {
            $user->delete();
            return redirect()->back()->with('success', 'User deleted successfully.');
        }
        return redirect()->back()->with('error', 'User not found or cannot delete admin.');
    }

    public function editUser($id)
    {
        $user = User::find($id);
        if ($user && !$user->is_admin) {
            return view('admin.edit_user', compact('user'));
        }
        return redirect()->back()->with('error', 'User not found or cannot edit admin.');
    }
}