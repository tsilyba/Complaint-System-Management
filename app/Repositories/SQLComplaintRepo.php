<?php

namespace App\Repositories;

use App\Models\Complaint; //

class SQLComplaintRepo{
   
     //Get all complaints (For the Admin Dashboard)
    
    public function getAll()
    {
        return Complaint::with('user')->latest()->get();
    }

    
    //Find a specific complaint by ID
     
    public function find($id)
    {
        return Complaint::find($id);
    }

   // Update complaint status
    public function updateStatus($id, $newStatus)
    {
        $complaint = Complaint::find($id);

        if ($complaint) {
            $complaint->status = $newStatus;
            $complaint->save(); 
            return $complaint; 
        }

        return null;
    }

    //save new complaint
    public function store($data)
    {
        $complaint = new Complaint();
        
        // Mapping form data to database columns
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
        return $complaint->id; 
    }
}