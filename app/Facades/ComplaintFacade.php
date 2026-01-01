<?php

namespace App\Facades;

use App\Repositories\SQLComplaintRepo;
use App\Services\NotificationService;
use App\Models\Complaint;

class ComplaintFacade
{
    protected $repo;
    protected $notificationService;

    // Dependency Injection
    public function __construct(SQLComplaintRepo $repo, NotificationService $notificationService)
    {
        $this->repo = $repo;
        $this->notificationService = $notificationService;
    }

    /**
     * WORKFLOW ORCHESTRATION
     * Sequence: Update (DB) -> Commit -> Notify (External)
     */
    public function updateStatus($id, $newStatus)
    {
        // Step 1: Internal System Transaction (Database Commit)
        $complaint = $this->repo->updateStatus($id, $newStatus);

        // Step 2: EAI Integration Logic
        // We only trigger the external service if the internal commit was successful
        if ($complaint && $complaint->wasChanged('status')) {

            // Step 3: Message Passing
            // Construct payload and call the external interface
            $this->notificationService->notifyResident(
                $complaint->user->email, // Target
                $complaint->user->id,    // Target User ID
                $complaint->id,          // Data Payload
                $complaint->status       // Data Payload
            );
        }

        return $complaint;
    }
}