<?php

namespace App\Http\Controllers\HR\Reports;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\Department;
use Illuminate\Http\Request;

class OvertimeReportController extends Controller
{
    public function index(Request $request)
    {
        $query = AttendanceRecord::with(['staff', 'department', 'shift'])
            ->where('overtime_minutes', '>', 0);

        // 🔍 Filters
        if ($request->employee) {
            $query->whereHas('staff', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->employee . '%');
            });
        }

        if ($request->department_id) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->shift_id) {
            $query->where('shift_id', $request->shift_id);
        }

        if ($request->from_date && $request->to_date) {
            $query->whereBetween('attendance_date', [$request->from_date, $request->to_date]);
        }

        $records = $query->latest()->paginate(10);

        // 💰 Overtime Calculation
        $rate = 100; // per hour

        foreach ($records as $r) {
            $r->overtime_hours = round($r->overtime_minutes / 60, 2);
            $r->overtime_amount = $r->overtime_hours * $rate;
        }

        // 📊 Summary
        $totalHours = $records->sum('overtime_hours');
        $totalAmount = $records->sum('overtime_amount');

        $departments = Department::all();

        return view('admin.hr.reports.overtime', compact(
            'records',
            'departments',
            'totalHours',
            'totalAmount'
        ));
    }
}