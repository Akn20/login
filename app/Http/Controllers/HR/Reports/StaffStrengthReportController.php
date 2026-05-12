<?php

namespace App\Http\Controllers\HR\Reports;

use App\Http\Controllers\Controller;
use App\Models\Staff;

class StaffStrengthReportController extends Controller
{
    public function index()
    {
        $staff = Staff::with([
            'department',
            'designation',
            'role'
        ])->get();

        $totalStaff = $staff->count();
        $activeStaff = $staff->where('status', 'Active')->count();
        $inactiveStaff = $staff->where('status', 'Inactive')->count();

        // RETURN UI PAGE (IMPORTANT)
        return view('admin.hr.reports.staff-strength', [
            'staff' => $staff,
            'totalStaff' => $totalStaff,
            'activeStaff' => $activeStaff,
            'inactiveStaff' => $inactiveStaff,
        ]);
    }
}