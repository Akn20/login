<?php

namespace App\Http\Controllers\HR\Payroll;

use App\Http\Controllers\Controller;

use App\Models\PrePayrollAdjustment;
use App\Models\SalaryStructure;
use App\Models\EmployeeSalaryAssignment;
use App\Models\PayrollResult;


class PayrollDashboardController extends Controller
{
    public function index()
    {
        $stats = [

            'pending_pre_payroll' =>
                PrePayrollAdjustment::where('status', 'pending')->count(),

            'salary_structures' =>
                SalaryStructure::count(),

            'salary_assignments' =>
                EmployeeSalaryAssignment::count(),

            'payroll_results' =>
                PayrollResult::count(),

        ];

        return view('hr.payroll.dashboard', compact('stats'));
    }

    public function apiDashboard()
{
    $stats = [

        'pending_pre_payroll' =>
            PrePayrollAdjustment::where('status', 'pending')->count(),

        'salary_structures' =>
            SalaryStructure::count(),

        'salary_assignments' =>
            EmployeeSalaryAssignment::count(),

        'payroll_results' =>
            PayrollResult::count(),
    ];

    return response()->json([
        'status' => true,
        'data' => $stats
    ]);
}
}