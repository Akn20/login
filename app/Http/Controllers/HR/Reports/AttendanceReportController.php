<?php

namespace App\Http\Controllers\HR\Reports;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\Department;
use Illuminate\Http\Request;

class AttendanceReportController extends Controller
{
    public function index(Request $request)
    {
        $query = AttendanceRecord::with(['staff', 'department', 'designation', 'shift']);

        // 🔍 Filters
        if ($request->from_date && $request->to_date) {
            $query->whereBetween('attendance_date', [$request->from_date, $request->to_date]);
        }

        if ($request->department_id) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $attendance = $query->latest()->paginate(10);

        // 📊 Calculations
        $totalDays = $attendance->count();
        $presentDays = $attendance->where('status', 'Present')->count();
        $absentDays = $attendance->where('status', 'Absent')->count();

        $attendancePercentage = $totalDays > 0
            ? round(($presentDays / $totalDays) * 100, 2)
            : 0;

        $departments = Department::all();

        return view('admin.hr.reports.attendance', compact(
            'attendance',
            'departments',
            'totalDays',
            'presentDays',
            'absentDays',
            'attendancePercentage'
        ));
    }
}