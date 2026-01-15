<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Complaint; 
use App\Facades\ComplaintFacade; 
use App\Repositories\SQLComplaintRepo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

        try {
            //  update via Facade (Database + Email)
            $result = $this->facade->updateStatus($id, $request->status);

            if (!$result) {
                throw new \Exception("System unable to find or update the complaint.");
            }

            return redirect()->back()->with('success', 'Status updated & Notification sent to Resident!');

        } catch (QueryException $e) {
            // Handle Database Failures
            return redirect()->back()->with('error', 'Database Error: Unable to save status change.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Update Failed: ' . $e->getMessage());
        }
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
        try {
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

            $complaints = $query->get();
            $pdf = Pdf::loadView('complaints.pdf', compact('complaints'));
            
            return $pdf->download('admin_complaints_report.pdf');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'PDF Generation Failed: ' . $e->getMessage());
        }
    }

    // 6. User Management

public function deleteUser($id)
{
    try {
        $user = User::findOrFail($id);

        // FIXED LINE: Use 'Auth::id()' instead of 'auth()->id()'
        // Also simplified '$user->getAttribute('id')' to '$user->id'
        if ($user->id === Auth::id()) {
            throw new \Exception("Operation Denied: You cannot delete your own account while logged in.");
        }

    if ($user->getAttribute('is_admin') == 1) {
    throw new \Exception("Security Violation: You cannot delete an Administrator account.");
}

        $user->delete();
        
        return redirect()->back()->with('success', 'User deleted successfully.');

    } catch (ModelNotFoundException $e) {
        return redirect()->back()->with('error', 'Error: User ID not found.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
    }
}
}