<?php

namespace App\Http\Controllers\Api\Reports;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\AttendanceRecord;

class DashboardApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'total_employees' => Staff::count(),
            'present_today' => AttendanceRecord::whereDate('attendance_date', today())
                ->where('status', 'Present')->count(),
            'on_leave' => 0, // optional
        ]);
    }
}