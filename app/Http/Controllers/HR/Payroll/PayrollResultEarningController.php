<?php

namespace App\Http\Controllers\HR\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PayrollResult;
use App\Models\PayrollResultEarning;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PayrollResultEarningController extends Controller
{
    /**
     * INDEX — show dropdown + generated records
     */
    public function index(Request $request)
    {
         // Fetch approved pre payroll records with employee name
    $approvedRecords = \App\Models\PrePayrollAdjustment::with('employee')
        ->where('status', 'Approved')
        ->get();

    // Unique employees from approved records
    $employees = $approvedRecords->map(function ($record) {
        return [
            'staff_id' => $record->employee_id,
            'name'     => optional($record->employee)->name ?? $record->employee_id,
        ];
    })->unique('staff_id')->values();

    // Months for selected employee
    $months = collect();
    $earnings = collect();       // for earning controller
    // $deductions = collect(); // for deduction controller
    $selectedPayrollResult = null;

    if ($request->staff_id) {
        $months = \App\Models\PrePayrollAdjustment::where('status', 'Approved')
            ->where('employee_id', $request->staff_id)
            ->pluck('payroll_month', 'payroll_month');
    }

    if ($request->staff_id && $request->payroll_month) {
        $selectedPayrollResult = \App\Models\PayrollResult::where('staff_id', $request->staff_id)
            ->where('payroll_month', $request->payroll_month)
            ->first();

        if ($selectedPayrollResult) {
            // For earnings controller:
            $earnings = \App\Models\PayrollResultEarning::where('payroll_result_id', $selectedPayrollResult->id)
                ->orderBy('display_order')->get();
            }
        }

        return view('hr.payroll.payroll_result_earnings.index', compact(
            'employees', 'months', 'earnings', 'selectedPayrollResult'
        ));
    }

    /**
     * GENERATE — auto create earnings from payroll result
     */
    public function generate(Request $request)
{
    $request->validate([
        'staff_id'      => 'required',
        'payroll_month' => 'required',
    ]);

    $payrollResult = PayrollResult::where('staff_id', $request->staff_id)
        ->where('payroll_month', $request->payroll_month)
        ->firstOrFail();

    if (PayrollResultEarning::where('payroll_result_id', $payrollResult->id)->exists()) {
        return redirect()->route('hr.payroll.payroll-result-earnings.index', [
            'staff_id'      => $request->staff_id,
            'payroll_month' => $request->payroll_month,
        ])->with('info', 'Earnings already generated.');
    }

   $gross = $payrollResult->fixed_earnings_total; // ✅ use fixed only for % split

$basic            = round($gross * 0.50, 2);
$hra              = round($gross * 0.20, 2);
$da               = round($gross * 0.10, 2);
$specialAllowance = round($gross - $basic - $hra - $da, 2); // Remaining of fixed
    $earnings = [
        [
            'earning_code'      => 'BASIC',
            'earning_name'      => 'Basic Salary',
            'earning_type'      => 'Fixed',
            'calculation_base'  => 'Gross',
            'calculation_value' => '50%',
            'amount'            => $basic,
            'taxable'           => 1,
            'pf_applicable'     => 1,
            'esi_applicable'    => 1,
            'display_order'     => 1,
        ],
        [
            'earning_code'      => 'HRA',
            'earning_name'      => 'House Rent Allowance',
            'earning_type'      => 'Fixed',
            'calculation_base'  => 'Gross',
            'calculation_value' => '20%',
            'amount'            => $hra,
            'taxable'           => 1,
            'pf_applicable'     => 0,
            'esi_applicable'    => 0,
            'display_order'     => 2,
        ],
        [
            'earning_code'      => 'DA',
            'earning_name'      => 'Dearness Allowance',
            'earning_type'      => 'Fixed',
            'calculation_base'  => 'Gross',
            'calculation_value' => '10%',
            'amount'            => $da,
            'taxable'           => 1,
            'pf_applicable'     => 1,
            'esi_applicable'    => 1,
            'display_order'     => 3,
        ],
        [
            'earning_code'      => 'SA',
            'earning_name'      => 'Special Allowance',
            'earning_type'      => 'Fixed',
            'calculation_base'  => 'Remaining',
            'calculation_value' => null,
            'amount'            => $specialAllowance,
            'taxable'           => 1,
            'pf_applicable'     => 0,
            'esi_applicable'    => 0,
            'display_order'     => 4,
        ],
    ];

    // Add Variable if exists
    if ($payrollResult->variable_earnings_total > 0) {
        $earnings[] = [
            'earning_code'      => 'VAR',
            'earning_name'      => 'Variable Earnings',
            'earning_type'      => 'Variable',
            'calculation_base'  => 'Gross',
            'calculation_value' => null,
            'amount'            => $payrollResult->variable_earnings_total,
            'taxable'           => 1,
            'pf_applicable'     => 0,
            'esi_applicable'    => 0,
            'display_order'     => 5,
        ];
    }

    foreach ($earnings as $order => $earning) {
        PayrollResultEarning::create([
            'id'                => Str::uuid(),
            'payroll_result_id' => $payrollResult->id,
            'created_by'        => Auth::id(),
            ...$earning,
        ]);
    }

    return redirect()->route('hr.payroll.payroll-result-earnings.index', [
        'staff_id'      => $request->staff_id,
        'payroll_month' => $request->payroll_month,
    ])->with('success', 'Earnings generated successfully.');
}
    public function show($payrollResultId)
{
    $payrollResult = PayrollResult::with('staff')->findOrFail($payrollResultId);

    $earnings = PayrollResultEarning::where('payroll_result_id', $payrollResultId)
        ->orderBy('display_order')
        ->get();

    return view('hr.payroll.payroll_result_earnings.show', compact(
        'payrollResult', 'earnings'
    ));
}
}