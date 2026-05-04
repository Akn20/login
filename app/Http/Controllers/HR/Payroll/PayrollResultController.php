<?php

namespace App\Http\Controllers\HR\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\PayrollResult;

class PayrollResultController extends Controller
{

    /**
     * =========================================
     * INDEX PAGE
     * =========================================
     */

    public function index()
    {
        $payrollResults = PayrollResult::orderBy(
            'created_on',
            'desc'
        )->get();

        return view(
            'hr.payroll.payroll_result.index',
            compact('payrollResults')
        );
    }



    /**
     * =========================================
     * SHOW PAGE
     * =========================================
     */

    public function show($id)
    {
        $payrollResult = PayrollResult::where(
            'id',
            $id
        )->firstOrFail();

        return view(
            'hr.payroll.payroll_result.show',
            compact('payrollResult')
        );
    }



    /**
     * =========================================
     * GENERATE PAYROLL RESULTS
     * =========================================
     */

    public function generate()
{

    /**
     * Get Approved Pre Payroll Records
     */

    $records = DB::table('pre_payroll_adjustments')
        ->where('status', 'Approved')
        ->get();


    /**
     * If no approved records
     */

    if ($records->isEmpty()) {

        return redirect()
            ->route('hr.payroll.payroll-result.index')
            ->with(
                'error',
                'No Approved Pre Payroll records found'
            );
    }


    /**
     * Track inserted count
     */

    $insertedCount = 0;


    foreach ($records as $ppa) {


        
        /**
 * Fix — Generate payroll_run_id if missing
 */

$payrollRunId = $ppa->payroll_run_id;

if (!$payrollRunId) {

    $payrollRunId =
        'RUN-' . now()->format('Ym');

}


        /**
         * Prevent Duplicate Insert
         * Same employee + same payroll run
         */

        $exists = PayrollResult::where(
        'payroll_run_id',
        $payrollRunId
    )
            ->where(
                'staff_id',
                $ppa->employee_id
            )
            ->exists();

        if ($exists) {
            continue;
        }


        /**
         * Get Salary Assignment
         */

        $assignment = DB::table('employee_salary_assignments')
            ->where('id', $ppa->salary_assignment_id)
            ->first();


        /**
         * Skip if assignment missing
         */

        if (!$assignment) {
            continue;
        }


        /**
         * Skip if salary structure missing
         */

        if (!$assignment->salary_structure_id) {
            continue;
        }


        $salaryStructureCode =
            $assignment->salary_structure_id;



        /**
         * Insert Payroll Result
         */

        PayrollResult::create([

            'id' => Str::uuid(),

            'payroll_run_id' =>
    $payrollRunId,

            'staff_id' =>
                $ppa->employee_id,

            'payroll_month' =>
                $ppa->payroll_month,

            'financial_year' =>
                'FY 2026-27',

            'academic_year' => null,

            'salary_assignment_id' =>
                $ppa->salary_assignment_id,

            'salary_structure_code' =>
                $salaryStructureCode,

            'working_days' =>
                $ppa->working_days,

            'paid_days' =>
                $ppa->days_paid,

            'lop_days' => $ppa->lop_days ?? 0,

            'overtime_hours' =>
                $ppa->ot_hours,

            'fixed_earnings_total' =>
                $ppa->fixed_earnings_total,

            'variable_earnings_total' =>
                $ppa->adhoc_earnings,

            'gross_earnings' =>
                $ppa->gross_earnings,
                

            'fixed_deductions_total' =>
                $ppa->fixed_deductions_total,

            'variable_deductions_total' =>
                $ppa->adhoc_deductions,

            'pf_employee' =>
                $ppa->pf_employee,

            'esi_employee' =>
                $ppa->esi_employee,

            'professional_tax' =>
                $ppa->professional_tax,

            'tds_amount' =>
                $ppa->tds_amount,

            'total_deductions' =>
                $ppa->total_deductions,

            'net_payable' =>
                $ppa->net_payable,

            'status' => 'Locked',

            'locked_on' => now(),

            'locked_by' =>
                $ppa->approved_by,

            'created_on' => now(),

            'remarks' =>
                'Generated from Pre Payroll'

        ]);


        $insertedCount++;

    }


    /**
     * Redirect After Generate
     */

    return redirect()
        ->route('hr.payroll.payroll-result.index')
        ->with(
            'success',
            $insertedCount .
            ' Payroll Results Generated Successfully'
        );

}

}