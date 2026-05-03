<?php

namespace App\Http\Controllers\HR\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PayrollResultDeduction;
use Illuminate\Support\Facades\Auth;

class PayrollResultDeductionController extends Controller
{
    public function index()
    {
        $records = PayrollResultDeduction::latest()->paginate(10);

        return view(
            'hr.payroll.payroll_result_deductions.index',
            compact('records')
        );
    }

    public function create()
    {
        return view(
            'hr.payroll.payroll_result_deductions.create'
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'deduction_code' => 'required',
            'deduction_name' => 'required',
            'deduction_type' => 'required',
            'calculation_logic' => 'required',
            'amount' => 'required|numeric|min:0',
        ]);

        PayrollResultDeduction::create([
            ...$request->all(),
            'created_by' => Auth::id()
        ]);

        return redirect()
            ->route('hr.payroll.payroll-result-deductions.index')
            ->with('success', 'Deduction Created Successfully');
    }

    public function show($id)
    {
        $record = PayrollResultDeduction::findOrFail($id);

        return view(
            'hr.payroll.payroll_result_deductions.show',
            compact('record')
        );
    }

    public function edit($id)
    {
        $record = PayrollResultDeduction::findOrFail($id);

        if (!$record->editable_flag) {
            return redirect()
                ->route('hr.payroll.payroll-result-deductions.index')
                ->with('error', 'Editing not allowed');
        }

        return view(
            'hr.payroll.payroll_result_deductions.edit',
            compact('record')
        );
    }

    public function update(Request $request, $id)
    {
        $record = PayrollResultDeduction::findOrFail($id);

        if (!$record->editable_flag) {
            return back()->with('error', 'Editing not allowed');
        }

        $request->validate([
            'deduction_code' => 'required',
            'deduction_name' => 'required',
            'deduction_type' => 'required',
            'calculation_logic' => 'required',
            'amount' => 'required|numeric|min:0',
        ]);

        $record->update($request->all());

        return redirect()
            ->route('hr.payroll.payroll-result-deductions.index')
            ->with('success', 'Updated Successfully');
    }

    public function destroy($id)
    {
        $record = PayrollResultDeduction::findOrFail($id);

        $record->delete();

        return back()->with('success', 'Deleted Successfully');
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