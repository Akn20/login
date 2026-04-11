<?php

namespace App\Http\Controllers\HR\Reports;

use App\Http\Controllers\Controller;
use App\Models\Staff;

class StaffStrengthReportController extends Controller
{
    public function index()
    {
        $staff = Staff::with(['department', 'designation', 'role'])
                    ->get();

        $totalStaff = $staff->count();
        $activeStaff = $staff->where('status', 'Active')->count();
        $inactiveStaff = $staff->where('status', 'Inactive')->count();

        return view('admin.hr.reports.staff-strength', compact(
            'staff',
            'totalStaff',
            'activeStaff',
            'inactiveStaff'
        ));
    }
}