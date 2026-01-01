<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    // 1. LIST ALL COMPLAINTS (With Search & Filter)
    public function index(Request $request)
    {
        // Start Query: Only get complaints for the logged-in user
        $query = Complaint::where('user_id', Auth::id());

        // A. Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            // We group these "OR" checks so they don't mess up the "User ID" check
            $query->where(function($q) use ($search) {
                $q->where('issue_type', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('id', 'LIKE', "%{$search}%");
            });
        }

        // B. Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Execute Query with Pagination (10 items per page)
        $complaints = $query->latest()->paginate(10);

        return view('complaints.index', compact('complaints'));
    }

    // 2. SHOW THE CREATE FORM
    public function create()
    {
        return view('complaints.create');
    }

    // 3. STORE NEW COMPLAINT
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'contact_number' => 'required', 'numeric', 'digits:11',
            'issue_type' => 'required',
            'description' => 'required',
            'photo' => 'required|image|max:2048',
        ]);

        $imagePath = $request->file('photo')->store('complaints', 'public');

        Complaint::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'address' => $request->address,
            'contact_number' => $request->contact_number,
            'issue_type' => $request->issue_type,
            'description' => $request->description,
            'image_path' => $imagePath,
            'status' => 'Pending', // Default status
        ]);

        return redirect()->route('complaints.index')->with('success', 'Complaint lodged successfully!');
    }

    // 4. SHOW SINGLE COMPLAINT DETAILS (Added this for the "View" button)
    public function show($id)
    {
        $complaint = Complaint::where('user_id', Auth::id())->findOrFail($id);
        return view('complaints.show', compact('complaint'));
    }

    // 5. SHOW EDIT FORM
    public function edit($id)
    {
        $complaint = Complaint::where('user_id', Auth::id())->findOrFail($id);

        // Security: Prevent editing if already processed
        if ($complaint->status !== 'Pending') {
            return redirect()->route('complaints.index')
                ->with('error', 'You cannot edit a complaint that is already processed.');
        }

        return view('complaints.edit', compact('complaint'));
    }

    // 6. UPDATE COMPLAINT
    public function update(Request $request, $id)
    {
        $complaint = Complaint::where('user_id', Auth::id())->findOrFail($id);

        if ($complaint->status !== 'Pending') {
            abort(403, 'Cannot edit processed complaints.');
        }

        $request->validate([
            'address' => 'required',
            'contact_number' => 'required', 'numberic', 'digits:11',
            'issue_type' => 'required',
            'description' => 'required',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['photo', 'name']); // Prevent name change

        if ($request->hasFile('photo')) {
            if ($complaint->image_path) {
                Storage::disk('public')->delete($complaint->image_path);
            }
            $data['image_path'] = $request->file('photo')->store('complaints', 'public');
        }

        $complaint->update($data);

        return redirect()->route('complaints.index')->with('success', 'Complaint updated successfully!');
    }

    // 7. DELETE COMPLAINT
    public function destroy($id)
    {
        $complaint = Complaint::where('user_id', Auth::id())->findOrFail($id);

        if ($complaint->status !== 'Pending') {
             return back()->with('error', 'Cannot delete a complaint that is currently being processed.');
        }

        if ($complaint->image_path) {
            Storage::disk('public')->delete($complaint->image_path);
        }

        $complaint->delete();

        return redirect()->route('complaints.index')->with('success', 'Complaint deleted successfully.');
    }
}