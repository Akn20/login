<?php

namespace App\Http\Controllers\HR\Reports;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\AttendanceRecord;

class ReportsDashboardController extends Controller
{
    public function index()
{
    // 📊 KPI
    $totalEmployees = Staff::count();

    // 📊 Department Salary Data
    $departments = Staff::with('department')->get()
        ->groupBy(fn($s) => $s->department->name ?? 'Unknown')
        ->map(function ($group) {
            return $group->sum(function ($s) {
                $basic = $s->basic_salary ?? 0;
                $allowances = $s->hra + $s->allowance;
                return $basic + $allowances;
            });
        });

    // 📊 Attendance Data
    $attendance = AttendanceRecord::selectRaw("
        DATE(attendance_date) as date,
        COUNT(*) as total,
        SUM(CASE WHEN status='Present' THEN 1 ELSE 0 END) as present
    ")
    ->groupBy('date')
    ->limit(7)
    ->get();

    return view('admin.hr.reports.dashboard', [
        'totalEmployees' => $totalEmployees,
        'deptLabels' => $departments->keys(),
        'deptValues' => $departments->values(),
        'attLabels' => $attendance->pluck('date'),
        'attValues' => $attendance->pluck('present'),
    ]);
}
}