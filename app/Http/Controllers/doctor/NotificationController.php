<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | NOTIFICATION LIST
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {

        $query = Notification::query();

        /*
        |--------------------------------------------------------------------------
        | FILTER : TYPE
        |--------------------------------------------------------------------------
        */

        if ($request->type) {

            $query->where(
                'type',
                $request->type
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER : STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->status == 'Unread') {

            $query->where(
                'is_read',
                0
            );
        }

        if ($request->status == 'Read') {

            $query->where(
                'is_read',
                1
            );
        }

        /*
        |--------------------------------------------------------------------------
        | GET NOTIFICATIONS
        |--------------------------------------------------------------------------
        */

        $notifications = $query
            ->latest()
            ->paginate(10);

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD COUNTS
        |--------------------------------------------------------------------------
        */

        $totalNotifications = Notification::count();

        $unreadNotifications = Notification::where(
            'is_read',
            0
        )->count();

        $criticalAlerts = Notification::where(
            'type',
            'Critical'
        )->count();

        $labReports = Notification::where(
            'type',
            'Lab Report'
        )->count();

        $followups = Notification::where(
            'type',
            'Follow-up'
        )->count();

        $medicationReviews = Notification::where(
            'type',
            'Medication Review'
        )->count();

        $emergencyAlerts = Notification::where(
            'type',
            'Emergency'
        )->count();

        return view(
            'doctor.notifications.index',
            compact(
                'notifications',
                'totalNotifications',
                'unreadNotifications',
                'criticalAlerts',
                'labReports',
                'followups',
                'medicationReviews',
                'emergencyAlerts'
            )
        );
    }



    /*
    |--------------------------------------------------------------------------
    | MARK AS READ
    |--------------------------------------------------------------------------
    */

    public function markAsRead($id)
    {

        $notification = Notification::findOrFail($id);

        $notification->update([

            'is_read' => true

        ]);

        return back()->with(
            'success',
            'Notification marked as read.'
        );
    }


    public function latestNotification()
    {
        $notification = Notification::latest()->first();

        return response()->json($notification);
    }





    /*
    |--------------------------------------------------------------------------
    | API : GET NOTIFICATIONS
    |--------------------------------------------------------------------------
    */

    public function apiIndex()
    {

        $notifications = Notification::latest()->get();

        return response()->json([

            'status' => true,

            'data' => $notifications

        ]);
    }



    /*
    |--------------------------------------------------------------------------
    | API : MARK AS READ
    |--------------------------------------------------------------------------
    */

    public function apiMarkAsRead($id)
    {

        $notification = Notification::findOrFail($id);

        $notification->update([

            'is_read' => true

        ]);

        return response()->json([

            'status' => true,

            'message' =>
                'Notification marked as read successfully'

        ]);
    }

    public function apiShow($id)
    {
        $notification = Notification::findOrFail($id);

        return response()->json([

            'status' => true,

            'data' => $notification

        ]);
    }

    public function apiSearch(Request $request)
    {
        $query = Notification::query();

        // TYPE FILTER
        if ($request->type) {

            $query->where(
                'type',
                $request->type
            );
        }

        // STATUS FILTER
        if ($request->status == 'Unread') {

            $query->where(
                'is_read',
                0
            );
        }

        if ($request->status == 'Read') {

            $query->where(
                'is_read',
                1
            );
        }

        // PRIORITY FILTER
        if ($request->priority) {

            $query->where(
                'priority',
                $request->priority
            );
        }

        // SEARCH TITLE
        if ($request->search) {

            $query->where(
                'title',
                'like',
                '%' . $request->search . '%'
            );
        }

        $notifications = $query
            ->latest()
            ->get();

        return response()->json([

            'status' => true,

            'data' => $notifications

        ]);
    }

    public function apiDashboard()
    {
        return response()->json([

            'status' => true,

            'data' => [

                'total_notifications' =>
                    Notification::count(),

                'unread_notifications' =>
                    Notification::where(
                        'is_read',
                        0
                    )->count(),

                'critical_alerts' =>
                    Notification::where(
                        'type',
                        'Critical'
                    )->count(),

                'lab_reports' =>
                    Notification::where(
                        'type',
                        'Lab Report'
                    )->count(),

                'followups' =>
                    Notification::where(
                        'type',
                        'Follow-up'
                    )->count(),

                'medication_reviews' =>
                    Notification::where(
                        'type',
                        'Medication Review'
                    )->count(),

                'emergency_alerts' =>
                    Notification::where(
                        'type',
                        'Emergency'
                    )->count(),
            ]

        ]);
    }
    public function apiMarkAllAsRead()
    {
        Notification::where(
            'is_read',
            0
        )->update([

                    'is_read' => true

                ]);

        return response()->json([

            'status' => true,

            'message' =>
                'All notifications marked as read'

        ]);
    }
    public function apiLatestNotification()
    {
        $notification = Notification::latest()->first();

        return response()->json([

            'status' => true,

            'data' => $notification

        ]);
    }

    public function apiDelete($id)
    {
        $notification = Notification::findOrFail($id);

        $notification->delete();

        return response()->json([

            'status' => true,

            'message' =>
                'Notification deleted successfully'

        ]);
    }

    public function apiUnread()
    {
        $notifications = Notification::where(
            'is_read',
            0
        )
            ->latest()
            ->get();

        return response()->json([

            'status' => true,

            'data' => $notifications

        ]);
    }
    public function apiRead()
    {
        $notifications = Notification::where(
            'is_read',
            1
        )
            ->latest()
            ->get();

        return response()->json([

            'status' => true,

            'data' => $notifications

        ]);
    }

}
