<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Notification; 

class NotificationService
{
  
    public function notifyResident($email, $userId, $complaintId, $newStatus)
    {
        // 1. Prepare the Message Payload
        $subject = "Update on Complaint #{$complaintId}";
        $messageBody = "Dear Resident,\n\nThe status of your complaint (ID: {$complaintId}) has been updated to: {$newStatus}.\n\nThank you,\nKampung Sentosa Management";

        // 2. Simulate Transmission to External System (SMTP/Gateway)
        try {
            Mail::raw($messageBody, function ($message) use ($email, $subject) {
                $message->to($email)
                        ->subject($subject);
            });

            Log::info(" Notification Sent: Email dispatched to {$email} for Complaint #{$complaintId}");

        } catch (\Exception $e) {
            // EAI Reliability: If email fails, log it but don't crash.
            Log::error("EAI Notification Failed: " . $e->getMessage());
        }

        // 3. Save to Database (In-App Notification)
        try {
            Notification::create([
                'user_id' => $userId, 
                'title'   => "Complaint #{$complaintId} Updated",
                'message' => "Your complaint status is now: {$newStatus}",
                'is_read' => false
            ]);
            
            return true;

        } catch (\Exception $e) {
            Log::error("Database Notification Failed: " . $e->getMessage());
            return false;
        }
    }
}