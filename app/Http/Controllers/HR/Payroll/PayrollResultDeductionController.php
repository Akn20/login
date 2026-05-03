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
       

        $record->delete();

        return back()->with(
            'success',
            'Deleted Successfully'
        );
    }

    // ---------------- API METHODS ---------------- //

// LIST
public function apiIndex()
{
    $records = PayrollResultDeduction::latest()->get();

    return response()->json([
        'success' => true,
        'message' => 'Deduction list fetched',
        'data' => $records
    ]);
}

// SHOW
public function apiShow($id)
{
    $record = PayrollResultDeduction::find($id);

    if (!$record) {
        return response()->json([
            'success' => false,
            'message' => 'Record not found'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $record
    ]);
}

// STORE
public function apiStore(Request $request)
{
    $request->validate([
        'payroll_result_id' => 'required',
        'deduction_code' => 'required',
        'deduction_name' => 'required',
        'deduction_type' => 'required|in:Fixed,Variable,Statutory',
        'calculation_logic' => 'required',
        'amount' => 'required|numeric|min:0',
    ]);

    $record = PayrollResultDeduction::create([
        'payroll_result_id' => $request->payroll_result_id,
        'deduction_code' => $request->deduction_code,
        'deduction_name' => $request->deduction_name,
        'deduction_type' => $request->deduction_type,
        'calculation_logic' => $request->calculation_logic,
        'amount' => round($request->amount, 2),
        'editable_flag' => true, // default
        'display_order' => $request->display_order,
        'created_by' => Auth::id()
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Deduction created successfully',
        'data' => $record
    ], 201);
}

// UPDATE
public function apiUpdate(Request $request, $id)
{
    $record = PayrollResultDeduction::find($id);

    if (!$record) {
        return response()->json([
            'success' => false,
            'message' => 'Record not found'
        ], 404);
    }

    if (!$record->editable_flag) {
        return response()->json([
            'success' => false,
            'message' => 'Editing not allowed'
        ], 403);
    }

    $request->validate([
        'deduction_code' => 'required',
        'deduction_name' => 'required',
        'deduction_type' => 'required|in:Fixed,Variable,Statutory',
        'calculation_logic' => 'required',
        'amount' => 'required|numeric|min:0',
    ]);

    $record->update([
        'deduction_code' => $request->deduction_code,
        'deduction_name' => $request->deduction_name,
        'deduction_type' => $request->deduction_type,
        'calculation_logic' => $request->calculation_logic,
        'amount' => round($request->amount, 2),
        'display_order' => $request->display_order,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Updated successfully',
        'data' => $record
    ]);
}

// DELETE
public function apiDelete($id)
{
    $record = PayrollResultDeduction::find($id);

    if (!$record) {
        return response()->json([
            'success' => false,
            'message' => 'Record not found'
        ], 404);
    }

    if (!$record->editable_flag) {
        return response()->json([
            'success' => false,
            'message' => 'Deletion not allowed'
        ], 403);
    }

    $record->delete();

    return response()->json([
        'success' => true,
        'message' => 'Deleted successfully'
    ]);
}
}