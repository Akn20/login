<?php

namespace App\Http\Controllers\HR\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrePayrollAdjustment;
use App\Models\Staff;
use App\Models\EmployeeSalaryAssignment; // IMPORTANT
use Illuminate\Support\Facades\Auth;

class PrePayrollAdjustmentController extends Controller
{
    // 🔹 INDEX
    public function index()
    {
        $records = PrePayrollAdjustment::with(['employee'])
            ->latest()
            ->paginate(10);

        return view('hr.payroll.pre_payroll_adjustment.index', compact('records'));
    }

    // 🔹 CREATE
    public function create()
    {
        $employees = Staff::pluck('name', 'id');

        // IMPORTANT (for dropdown)
        $assignments = EmployeeSalaryAssignment::all();

        return view(
            'hr.payroll.pre_payroll_adjustment.create',
            compact('employees', 'assignments')
        );
    }

    //  STORE
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'salary_assignment_id' => 'required',
            'payroll_month' => 'required',
            'working_days' => 'required',
            'days_paid' => 'required|lte:working_days',
            'status' => 'required',
        ]);

        // CALCULATION
        $gross = ($request->fixed_earnings_total ?? 0)
               + ($request->adhoc_earnings ?? 0);

        $deductions = ($request->fixed_deductions_total ?? 0)
                    + ($request->adhoc_deductions ?? 0);

        $net = $gross - $deductions;

        PrePayrollAdjustment::create([
            ...$request->all(),
            'gross_earnings' => $gross,
            'total_deductions' => $deductions,
            'net_payable' => $net,
            'created_by' => Auth::id()
        ]);

   return redirect()->route('hr.payroll.pre-payroll.index')
            ->with('success', 'Created Successfully');
    }
}