<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    // 1. LIST ALL COMPLAINTS (Index)
    public function index()
    {
        // Get only complaints belonging to the logged-in user
        $complaints = Complaint::where('user_id', Auth::id())->latest()->get();
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
            'contact_number' => 'required',
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

    // 4. SHOW EDIT FORM
    public function edit(Complaint $complaint)
    {
        // Security: Ensure user owns this complaint
        if ($complaint->user_id !== Auth::id()) {
            abort(403);
        }
        return view('complaints.edit', compact('complaint'));
    }

    // 5. UPDATE COMPLAINT
    public function update(Request $request, Complaint $complaint)
    {
        if ($complaint->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'contact_number' => 'required',
            'issue_type' => 'required',
            'description' => 'required',
            'photo' => 'nullable|image|max:2048', // Photo is optional on update
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($complaint->image_path) {
                Storage::disk('public')->delete($complaint->image_path);
            }
            // Upload new photo
            $data['image_path'] = $request->file('photo')->store('complaints', 'public');
        }

        $complaint->update($data);

        return redirect()->route('complaints.index')->with('success', 'Complaint updated successfully!');
    }

    // 6. DELETE COMPLAINT
    public function destroy(Complaint $complaint)
    {
        if ($complaint->user_id !== Auth::id()) {
            abort(403);
        }

        // Delete photo from storage
        if ($complaint->image_path) {
            Storage::disk('public')->delete($complaint->image_path);
        }

        $complaint->delete();

        return redirect()->route('complaints.index')->with('success', 'Complaint deleted successfully.');
    }
}
