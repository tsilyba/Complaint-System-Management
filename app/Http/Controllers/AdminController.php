<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;

class AdminController extends Controller
{
    // Show Admin Dashboard with ALL complaints
    public function index()
    {
        $complaints = Complaint::with('user')->latest()->get(); // 'with user' loads the user name who complained
        return view('admin.dashboard', compact('complaints'));
    }

    // Admin can update the status (e.g., from Pending -> Resolved)
    public function updateStatus(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Pending,In Progress,Resolved'
        ]);

        $complaint->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Complaint status updated!');
    }
}
