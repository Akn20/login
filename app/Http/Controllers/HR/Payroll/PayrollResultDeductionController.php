<?php

namespace App\Http\Controllers\HR\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PayrollResult;
use App\Models\PayrollResultDeduction;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PayrollResultDeductionController extends Controller
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
        $months     = collect();
        $deductions = collect();
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
                $deductions = \App\Models\PayrollResultDeduction::where(
                    'payroll_result_id', $selectedPayrollResult->id
                )->orderBy('display_order')->get();
            }
        }

        return view('hr.payroll.payroll_result_deductions.index', compact(
            'employees', 'months', 'deductions', 'selectedPayrollResult'
        ));
    }

    /**
     * GENERATE — auto create deductions from payroll result
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

        // Already generated → just redirect
        if (PayrollResultDeduction::where('payroll_result_id', $payrollResult->id)->exists()) {
            return redirect()->route('hr.payroll.payroll-result-deductions.index', [
                'staff_id'      => $request->staff_id,
                'payroll_month' => $request->payroll_month,
            ])->with('info', 'Deductions already generated.');
        }

        // ✅ Take values directly from payroll result (calculated by teammate's module)
        $pf  = $payrollResult->pf_employee;
        $esi = $payrollResult->esi_employee;
        $pt  = $payrollResult->professional_tax;
        $tds = $payrollResult->tds_amount;

        // EMI = total_deductions - (pf + esi + pt + tds) → remaining
        $emi = round(
            $payrollResult->total_deductions - $pf - $esi - $pt - $tds,
            2
        );
        $emi = max($emi, 0); // never negative

        $deductions = [];

        // PF
        if ($pf > 0) {
            $deductions[] = [
                'deduction_code'    => 'PF',
                'deduction_name'    => 'Provident Fund (Employee)',
                'deduction_type'    => 'Statutory',
                'calculation_base'  => 'Gross',
                'calculation_logic' => '%',
                'calculation_value' => 12.00,
                'amount'            => $pf,
                'editable_flag'     => 0,
                'display_order'     => 1,
            ];
        }

        // ESI
        if ($esi > 0) {
            $deductions[] = [
                'deduction_code'    => 'ESI',
                'deduction_name'    => 'ESI (Employee)',
                'deduction_type'    => 'Statutory',
                'calculation_base'  => 'Gross',
                'calculation_logic' => '%',
                'calculation_value' => 0.75,
                'amount'            => $esi,
                'editable_flag'     => 0,
                'display_order'     => 2,
            ];
        }

        // Professional Tax
        if ($pt > 0) {
            $deductions[] = [
                'deduction_code'    => 'PT',
                'deduction_name'    => 'Professional Tax',
                'deduction_type'    => 'Statutory',
                'calculation_base'  => 'Gross',
                'calculation_logic' => 'Slab',
                'calculation_value' => null,
                'amount'            => $pt,
                'editable_flag'     => 0,
                'display_order'     => 3,
            ];
        }

        // TDS
        if ($tds > 0) {
            $deductions[] = [
                'deduction_code'    => 'TDS',
                'deduction_name'    => 'TDS',
                'deduction_type'    => 'Statutory',
                'calculation_base'  => 'Gross',
                'calculation_logic' => '%',
                'calculation_value' => null,
                'amount'            => $tds,
                'editable_flag'     => 0,
                'display_order'     => 4,
            ];
        }

        // EMI — remaining after statutory deductions
        if ($emi > 0) {
            $deductions[] = [
                'deduction_code'    => 'EMI',
                'deduction_name'    => 'EMI / Loan Deduction',
                'deduction_type'    => 'Fixed',
                'calculation_base'  => null,
                'calculation_logic' => 'EMI',
                'calculation_value' => null,
                'amount'            => $emi,
                'editable_flag'     => 1,
                'display_order'     => 5,
            ];
        }

        foreach ($deductions as $deduction) {
            PayrollResultDeduction::create([
                'id'                => Str::uuid(),
                'payroll_result_id' => $payrollResult->id,
                'created_by'        => Auth::id(),
                ...$deduction,
            ]);
        }

        return redirect()->route('hr.payroll.payroll-result-deductions.index', [
            'staff_id'      => $request->staff_id,
            'payroll_month' => $request->payroll_month,
        ])->with('success', 'Deductions generated successfully.');
    }

    /**
     * SHOW — detailed deduction breakdown for a payroll result
     */
    public function show($payrollResultId)
    {
        $payrollResult = PayrollResult::with('staff')->findOrFail($payrollResultId);

        $deductions = PayrollResultDeduction::where('payroll_result_id', $payrollResultId)
            ->orderBy('display_order')
            ->get();

        return view('hr.payroll.payroll_result_deductions.show', compact(
            'payrollResult', 'deductions'
        ));
    }
}