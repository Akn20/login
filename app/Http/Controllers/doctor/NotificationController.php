<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::latest()->get();

        return view('doctor.notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);

        $notification->update(['is_read' => true]);

        return back()->with('success', 'Notification marked as read.');
    }
    public function apiIndex()
    {
        $notifications = Notification::select(
            'id',
            'message',
            'is_read',
            'created_at'
        )->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $notifications
        ]);
    }

    // ================= MARK AS READ =================
    public function apiMarkAsRead($id)
    {
        $notification = Notification::findOrFail($id);

        $notification->update([
            'is_read' => true
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Notification marked as read successfully'
        ]);
    }
}
