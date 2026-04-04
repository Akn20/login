<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\LeaveApplication;
use App\Models\Staff;
use Carbon\Carbon;

class HRDashboardController extends Controller
{
    public function index()
    {
        // Top stats
        $stats = [
            'total_staff' => Staff::count(),
            'active_staff' => Staff::where('status', 'active')->count(),
            'pending_leaves' => LeaveApplication::where('status', 'pending')->count(),
        ];

        // 1) Headcount by Department (for bar chart)
        $departments = Staff::selectRaw('department_id, COUNT(*) as total')
            ->with('department:id,department_name')
            ->groupBy('department_id')
            ->get();

        $departmentLabels = $departments->map(
            fn ($row) => $row->department->department_name ?? 'Unknown'
        );
        $departmentCounts = $departments->pluck('total');

        // 2) Attendance last 7 days (stacked present vs absent)
        $rangeDays = 7;
        $fromDate = Carbon::today()->subDays($rangeDays - 1);

        // build continuous date range
        $dates = collect();
        for ($i = $rangeDays - 1; $i >= 0; $i--) {
            $dates->push(Carbon::today()->subDays($i)->format('Y-m-d'));
        }

        // Attendance per day (assuming one row per staff per day, with status field)
        // If your model uses a different field name, adjust 'status'.
        $attendance = AttendanceRecord::selectRaw(
            "attendance_date,
                 SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present_total,
                 SUM(CASE WHEN status = 'absent'  THEN 1 ELSE 0 END) as absent_total"
        )
            ->whereDate('attendance_date', '>=', $fromDate)
            ->groupBy('attendance_date')
            ->orderBy('attendance_date')
            ->get();

        $attendanceMap = $attendance->mapWithKeys(function ($row) {
            $key = Carbon::parse($row->attendance_date)->format('Y-m-d');

            return [
                $key => [
                    'present' => (int) $row->present_total,
                    'absent' => (int) $row->absent_total,
                ],
            ];
        });

        $attendanceLabels = $dates;
        $presentCounts = $dates->map(fn ($d) => $attendanceMap[$d]['present'] ?? 0);
        $absentCounts = $dates->map(fn ($d) => $attendanceMap[$d]['absent'] ?? 0);

        // 3) Staff status distribution (for donut chart)
        // Adjust statuses as per your Staff table.
        $statusLabels = ['Active', 'Inactive'];
        $statusCounts = [
            Staff::where('status', 'active')->count(),
            Staff::where('status', 'inactive')->count(),
        ];

        return view('hr.dashboard.index', [
            'stats' => $stats,
            'departmentLabels' => $departmentLabels,
            'departmentCounts' => $departmentCounts,
            'attendanceLabels' => $attendanceLabels,
            'presentCounts' => $presentCounts,
            'absentCounts' => $absentCounts,
            'statusLabels' => $statusLabels,
            'statusCounts' => $statusCounts,
        ]);
    }
}
