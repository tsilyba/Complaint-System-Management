<?php

namespace App\Facades;

use App\Repositories\SQLComplaintRepo;
use App\Services\NotificationService;

class ComplaintFacade
{
    protected $repo;
    protected $notificationService;

    
    public function __construct(SQLComplaintRepo $repo, NotificationService $notificationService)
    {
        $this->repo = $repo;
        $this->notificationService = $notificationService;
    }

    public function updateStatus($id, $newStatus)
    {
        $complaint = $this->repo->updateStatus($id, $newStatus);

        
        if ($complaint && $complaint->wasChanged('status')) {

            $this->notificationService->notifyResident(
                $complaint->user->email, 
                $complaint->user->id,    
                $complaint->id,          
                $complaint->status       
            );
        }

        return $complaint;
    }
}