<?php

namespace App\Repositories;

use App\Models\Complaint; //

class SQLComplaintRepo{
    /**
     * Get all complaints (For the Admin Dashboard)
     */
    public function getAll()
    {
        return Complaint::with('user')->latest()->get();
    }

    /**
     * Find a specific complaint by ID
     */
    public function find($id)
    {
        return Complaint::find($id);
    }

    /**
     * Update status (The "Commit" step of EAI)
     */
    public function updateStatus($id, $newStatus)
    {
        $complaint = Complaint::find($id);

        if ($complaint) {
            $complaint->status = $newStatus;
            $complaint->save(); // <--- Database Commit
            return $complaint; // Changed to return the ID instead of the model
        }

        return null;
    }

    /**
     * Save a new complaint (For Submission Form)
     * Using your specific fillable fields
     */
    public function store($data)
    {
        $complaint = new Complaint();
        
        // Mapping your form data to your database columns
        $complaint->user_id = $data['user_id'];
        $complaint->name = $data['name'];
        $complaint->address = $data['address'];
        $complaint->contact_number = $data['contact_number'];
        $complaint->issue_type = $data['issue_type'];
        $complaint->description = $data['description'];
        $complaint->status = 'Pending'; // Default status

        // Handle Image Upload (matches your 'image_path' field)
        if (isset($data['photo'])) {
            $path = $data['photo']->store('complaints', 'public');
            $complaint->image_path = $path;
        }

        $complaint->save();
        return $complaint->id; // Changed to return the ID instead of the model
    }
}