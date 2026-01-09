<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Repositories\SQLComplaintRepo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class ComplaintController extends Controller
{
    protected $repo;

    public function __construct(SQLComplaintRepo $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
       
        $query = Complaint::where('user_id', Auth::id());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('issue_type', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('id', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $complaints = $query->latest()->paginate(10);

        return view('complaints.index', compact('complaints'));
    }

    public function create()
    {
        return view('complaints.create');
    }

    // 3. REFACTORED STORE METHOD 
    public function store(Request $request)
    {
        // Validation stays in Controller 
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'contact_number' => 'required|numeric|digits:11',
            'issue_type' => 'required',
            'description' => 'required',
            'photo' => 'required|image|max:2048',
        ]);

        try {
            // TESTING EXCEPTION (Uncomment to test)
            // throw new \Illuminate\Database\QueryException('Connection Failed', [], new \Exception()); 

            $this->repo->store($request->all());

            return redirect()->route('complaints.index')
                ->with('success', 'Complaint lodged successfully!');

        } catch (QueryException $e) {
            return back()->withInput()->with('error', 'Database Error: Failed to lodge complaint. Please try again later.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'System Error: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $complaint = Complaint::where('user_id', Auth::id())->findOrFail($id);
        return view('complaints.show', compact('complaint'));
    }

    public function edit($id)
    {
        $complaint = Complaint::where('user_id', Auth::id())->findOrFail($id);

        if ($complaint->status !== 'Pending') {
            return redirect()->route('complaints.index')
                ->with('error', 'You cannot edit a complaint that is already processed.');
        }

        return view('complaints.edit', compact('complaint'));
    }

    public function update(Request $request, $id)
    {
        $complaint = Complaint::where('user_id', Auth::id())->findOrFail($id);

        if ($complaint->status !== 'Pending') {
            abort(403, 'Cannot edit processed complaints.');
        }

        $request->validate([
            'address' => 'required',
            'contact_number' => 'required|numeric|digits:11', 
            'description' => 'required',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['photo', 'name']);

        if ($request->hasFile('photo')) {
            if ($complaint->image_path) {
                Storage::disk('public')->delete($complaint->image_path);
            }
            $data['image_path'] = $request->file('photo')->store('complaints', 'public');
        }

        $complaint->update($data);

        return redirect()->route('complaints.index')->with('success', 'Complaint updated successfully!');
    }

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