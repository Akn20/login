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
    $query = AttendanceRecord::with([
        'staff',
        'department',
        'designation',
        'shift'
    ]);

    if ($request->from_date && $request->to_date) {
        $query->whereBetween(
            'attendance_date',
            [$request->from_date, $request->to_date]
        );
    }

    if ($request->department_id) {
        $query->where(
            'department_id',
            $request->department_id
        );
    }

    if ($request->status) {
        $query->where(
            'status',
            $request->status
        );
    }

    $attendance = $query
        ->latest()
        ->paginate(10);

    $departments = Department::all();

    // ADD THESE CALCULATIONS
    $totalDays = $attendance->count();

    $presentDays = $attendance
        ->where('status', 'Present')
        ->count();

    $absentDays = $attendance
        ->where('status', 'Absent')
        ->count();

    $attendancePercentage =
        $totalDays > 0
        ? round(
            ($presentDays / $totalDays) * 100,
            2
          )
        : 0;

    return view(
        'admin.hr.reports.attendance',
        compact(
            'attendance',
            'departments',
            'totalDays',
            'presentDays',
            'absentDays',
            'attendancePercentage'
        )
    );
}public function apiIndex(Request $request)
{
    $query = AttendanceRecord::with([
        'staff',
        'department',
        'designation',
        'shift'
    ]);

    if ($request->from_date && $request->to_date) {
        $query->whereBetween(
            'attendance_date',
            [$request->from_date, $request->to_date]
        );
    }

    if ($request->department_id) {
        $query->where(
            'department_id',
            $request->department_id
        );
    }

    if ($request->status) {
        $query->where(
            'status',
            $request->status
        );
    }

    // Attendance data
    $attendance = $query
        ->latest()
        ->get();

    // ALL departments
    $departments = Department::select(
        'id',
        'department_name'
    )->get();

    return response()->json([
        'attendance' => $attendance,
        'departments' => $departments
    ]);
}
    public function store(Request $request)
{
    // ✅ Validation
    $request->validate([
        'employee_id' => 'required',
        'department_id' => 'required',
        'designation_id' => 'required',
        'shift_id' => 'required',
        'attendance_date' => 'required|date',
        'status' => 'required',
    ]);

    // ✅ Check duplicate
    $exists = AttendanceRecord::where('employee_id', $request->employee_id)
        ->where('attendance_date', $request->attendance_date)
        ->exists();

    if ($exists) {
        return redirect()->back()->with('error', 'Attendance already recorded for this date');
    }

    // ✅ Calculate working hours
    $workingHours = null;

    if ($request->check_in && $request->check_out) {
        $checkIn = strtotime($request->check_in);
        $checkOut = strtotime($request->check_out);

        $diff = $checkOut - $checkIn;
        $workingHours = gmdate('H:i', $diff);
    }

    // ✅ Calculate late minutes
    $lateMinutes = 0;

    if ($request->check_in) {
        $shift = \App\Models\Shift::find($request->shift_id);

        if ($shift && $shift->start_time) {
            $lateMinutes = max(
                0,
                (strtotime($request->check_in) - strtotime($shift->start_time)) / 60
            );
        }
    }

    // ✅ Calculate overtime
    $overtimeMinutes = 0;

    if ($request->check_out) {
        $shift = \App\Models\Shift::find($request->shift_id);

        if ($shift && $shift->end_time) {
            $overtimeMinutes = max(
                0,
                (strtotime($request->check_out) - strtotime($shift->end_time)) / 60
            );
        }
    }

    // ✅ Save data
    AttendanceRecord::create([
        'employee_id' => $request->employee_id,
        'department_id' => $request->department_id,
        'designation_id' => $request->designation_id,
        'shift_id' => $request->shift_id,
        'attendance_date' => $request->attendance_date,
        'check_in' => $request->check_in,
        'check_out' => $request->check_out,
        'status' => $request->status,
        'late_minutes' => $lateMinutes,
        'overtime_minutes' => $overtimeMinutes,
    ]);

    // ✅ Redirect with success
    return redirect()
        ->route('hr.attendance.index')
        ->with('success', 'Attendance recorded successfully');
}
}