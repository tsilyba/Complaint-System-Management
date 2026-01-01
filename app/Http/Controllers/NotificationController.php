<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        // Fetch notifications for the logged-in user, newest first
        $notifications = Notification::where('user_id', Auth::id())
                                     ->latest()
                                     ->get();

        return view('notifications.index', compact('notifications'));
    }

    // Optional: Mark as read
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notification->update(['is_read' => true]);
        
        return redirect()->back()->with('success', 'Marked as read.');
    }
}