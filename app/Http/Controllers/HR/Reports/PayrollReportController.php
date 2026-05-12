<?php

namespace App\Http\Controllers\HR\Reports;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Allowance;
use App\Models\PayrollDeduction;
use Illuminate\Http\Request;
use App\Models\DeductionRuleSet;
use App\Models\AllowanceRuleSet;
use App\Models\PayrollDeductionRecord;
use Barryvdh\DomPDF\Facade\Pdf;

class PayrollReportController extends Controller
{
    public function index(Request $request)
    {
        $staff = Staff::with(['department'])->get();

        $report = [];

       foreach ($staff as $s) {

    $salary = $this->calculateSalary($s);

    $report[] = [
        'id' => $s->id,
        'employee_id' => $s->employee_id,
        'name' => $s->name,
        'department' => $s->department->name ?? '-',
        'basic' => $salary['basic'],
        'allowances' => $salary['allowances'],
        'pf' => $salary['pf'],
        'esi' => $salary['esi'],
        'tax' => $salary['tax'],
        'deductions' => $salary['deductions'],
        'gross' => $salary['gross'],
        'net' => $salary['net'],
        'status' => 'Processed',
    ];
}

        return view('admin.hr.reports.payroll', compact('report'));
    }

    private function calculateSalary($s)
{
    $basic = $s->basic_salary ?? 0;

    // Allowances
    $allowances = Allowance::where('status', 1)
        ->sum('calculation_value');

    $gross = $basic + $allowances;

    // PF
    $pf = round($basic * 0.12, 2);

    // ESI
    $esi = ($gross <= 21000) ? round($gross * 0.0075, 2) : 0;

    // Tax
    $taxRule = DeductionRuleSet::where('rule_category', 'Statutory')
        ->where('calculation_type', 'Percentage')
        ->first();

    $tax = $taxRule ? round(($gross * $taxRule->calculation_value) / 100, 2) : 0;

    // Other deductions
    $other = PayrollDeduction::where('status', 'active')->count() * 50;

    $totalDeductions = $pf + $esi + $tax + $other;

    $net = $gross - $totalDeductions;

    return [
        'basic' => $basic,
        'allowances' => $allowances,
        'pf' => $pf,
        'esi' => $esi,
        'tax' => $tax,
        'deductions' => $totalDeductions,
        'gross' => $gross,
        'net' => $net,
    ];
}

public function payslip($id)
{
    $staff = Staff::with('department')->findOrFail($id);

    $salary = $this->calculateSalary($staff);

    $data = array_merge([
        'staff' => $staff
    ], $salary);

    $pdf = Pdf::loadView('admin.hr.reports.payslip', $data);

    return $pdf->download('payslip-'.$staff->employee_id.'.pdf');
}
}