<?php

namespace App\Http\Controllers\HR\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use App\Models\PayrollResult;
use App\Models\PayrollResultDeduction;

class PayrollResultDeductionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $records = PayrollResultDeduction::with('payrollResult')
            ->latest()
            ->paginate(10);

        return view(
            'hr.payroll.payroll_result_deductions.index',
            compact('records')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
{
    $payrollResults = PayrollResult::orderBy(
        'created_on',
        'desc'
    )->get();

    return view(
        'hr.payroll.payroll_result_deductions.create',
        compact('payrollResults')
    );
}

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'payroll_result_id' => 'required',

            'deduction_code' => [

                'required',

                Rule::unique(
                    'payroll_result_deductions',
                    'deduction_code'
                )->where(function ($query) use ($request) {

                    return $query->where(
                        'payroll_result_id',
                        $request->payroll_result_id
                    );
                }),
            ],

            'deduction_name' => 'required',

            'deduction_type' => 'required',

            'amount' => 'required|numeric|min:0',

            'calculation_base'
                => 'required_if:deduction_type,Variable,Statutory',

            'calculation_logic'
                => 'required_if:deduction_type,Variable,Statutory',

            'calculation_value'
                => 'required_if:deduction_type,Variable,Statutory|nullable|numeric|min:0',
        ]);

        // FIXED DEDUCTIONS SHOULD NOT USE CALCULATION
        if (
            $request->deduction_type === 'Fixed' &&
            (
                $request->filled('calculation_base') ||
                $request->filled('calculation_logic') ||
                $request->filled('calculation_value')
            )
        ) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'calculation_base'
                        => 'Fixed deductions do not require calculation fields.',
                ]);
        }

        PayrollResultDeduction::create([

            ...$request->all(),

            'created_by' => Auth::id()
        ]);

        return redirect()
            ->route('hr.payroll.payroll-result-deductions.index')
            ->with(
                'success',
                'Deduction Created Successfully'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $record = PayrollResultDeduction::with(
            'payrollResult'
        )->findOrFail($id);

        return view(
            'hr.payroll.payroll_result_deductions.show',
            compact('record')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $record = PayrollResultDeduction::with(
            'payrollResult'
        )->findOrFail($id);

        // LOCK CHECK
        if (
            $record->payrollResult &&
            $record->payrollResult->status === 'Locked'
        ) {
            return redirect()->back()
                ->with(
                    'error',
                    'Cannot edit locked payroll.'
                );
        }

        // EDITABLE FLAG CHECK
        if (!$record->editable_flag) {

            return redirect()
                ->route(
                    'hr.payroll.payroll-result-deductions.index'
                )
                ->with(
                    'error',
                    'Editing not allowed'
                );
        }

        $payrollResults = PayrollResult::orderBy(
            'created_on',
            'desc'
        )->get();

        return view(
            'hr.payroll.payroll_result_deductions.edit',
            compact(
                'record',
                'payrollResults'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $record = PayrollResultDeduction::with(
            'payrollResult'
        )->findOrFail($id);

        // LOCK CHECK
        if (
            $record->payrollResult &&
            $record->payrollResult->status === 'Locked'
        ) {
            return redirect()->back()
                ->with(
                    'error',
                    'Cannot edit locked payroll.'
                );
        }

        // EDITABLE CHECK
        if (!$record->editable_flag) {

            return back()->with(
                'error',
                'Editing not allowed'
            );
        }

        $request->validate([

            'payroll_result_id' => 'required',

            'deduction_code' => [

                'required',

                Rule::unique(
                    'payroll_result_deductions',
                    'deduction_code'
                )
                ->ignore($record->id)
                ->where(function ($query) use ($request) {

                    return $query->where(
                        'payroll_result_id',
                        $request->payroll_result_id
                    );
                }),
            ],

            'deduction_name' => 'required',

            'deduction_type' => 'required',

            'amount' => 'required|numeric|min:0',

            'calculation_base'
                => 'required_if:deduction_type,Variable,Statutory',

            'calculation_logic'
                => 'required_if:deduction_type,Variable,Statutory',

            'calculation_value'
                => 'required_if:deduction_type,Variable,Statutory|nullable|numeric|min:0',
        ]);

        // FIXED VALIDATION
        if (
            $request->deduction_type === 'Fixed' &&
            (
                $request->filled('calculation_base') ||
                $request->filled('calculation_logic') ||
                $request->filled('calculation_value')
            )
        ) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'calculation_base'
                        => 'Fixed deductions do not require calculation fields.',
                ]);
        }

        $record->update($request->all());

        return redirect()
            ->route(
                'hr.payroll.payroll-result-deductions.index'
            )
            ->with(
                'success',
                'Updated Successfully'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $record = PayrollResultDeduction::with(
            'payrollResult'
        )->findOrFail($id);

        // LOCK CHECK
        if (
            $record->payrollResult &&
            $record->payrollResult->status === 'Locked'
        ) {
            return redirect()->back()
                ->with(
                    'error',
                    'Cannot delete locked payroll.'
                );
        }

        $record->delete();

        return back()->with(
            'success',
            'Deleted Successfully'
        );
    }
}