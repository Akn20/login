<?php
namespace App\Http\Controllers\HR\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PayrollResultEarning;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PayrollResultEarningController extends Controller
{
    // INDEX
    public function index()
    {
        $records = PayrollResultEarning::latest()->paginate(10);
        return view('hr.payroll.payroll_result_earnings.index', compact('records'));
    }

    // CREATE
    public function create()
    {
        return view('hr.payroll.payroll_result_earnings.create');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'payroll_result_id' => 'required',
           'earning_code' => ['required', Rule::unique(...)],
            'earning_name' => 'required',
            'earning_type' => 'required',
            'amount' => 'required|numeric|min:0',
            'calculation_base'  => 'required_if:earning_type,Variable,OT',
            'calculation_value' => 'required_if:earning_type,Variable,OT|nullable|numeric|min:0',
            ]);
        if (
    $request->earning_type === 'Fixed' &&
    ($request->filled('calculation_base') || $request->filled('calculation_value'))
) {
    return redirect()->back()
        ->withInput()
        ->withErrors([
            'calculation_base' => 'Earning type is Fixed — Calculation Base and Value are not required and will be ignored.',
        ]);
}

        PayrollResultEarning::create([
            ...$request->all(),
            'created_by' => Auth::id()
        ]);

        return redirect()->route('hr.payroll.payroll-result-earnings.index')
            ->with('success', 'Earning added successfully');
    }

    // SHOW
    public function show($id)
    {
        $record = PayrollResultEarning::findOrFail($id);
        return view('hr.payroll.payroll_result_earnings.show', compact('record'));
    }

    // EDIT
    public function edit($id)
    {
        $record = PayrollResultEarning::findOrFail($id);
         // ✅ Block edit if payroll is finalized
    if ($record->payrollResult && $record->payrollResult->status === 'finalized') {
        return redirect()->back()->with('error', 'Cannot edit after payroll finalization.');
    }
        return view('hr.payroll.payroll_result_earnings.edit', compact('record'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $record = PayrollResultEarning::findOrFail($id);
         if ($record->payrollResult && $record->payrollResult->status === 'finalized') {
        return redirect()->back()->with('error', 'Cannot edit after payroll finalization.');
    }

        $request->validate([
          'earning_code' => ['required', Rule::unique(...)],
            'earning_name' => 'required',
            'earning_type' => 'required',
            'amount' => 'required|numeric|min:0',
            'calculation_base'  => 'required_if:earning_type,Variable,OT',
           'calculation_value' => 'required_if:earning_type,Variable,OT|nullable|numeric|min:0',
        ]);
        if (
    $request->earning_type === 'Fixed' &&
    ($request->filled('calculation_base') || $request->filled('calculation_value'))
) {
    return redirect()->back()
        ->withInput()
        ->withErrors([
            'calculation_base' => 'Earning type is Fixed — Calculation Base and Value are not required and will be ignored.',
        ]);
}

        $record->update($request->all());

        return redirect()->route('hr.payroll.payroll-result-earnings.index')
            ->with('success', 'Updated successfully');
    }

    // DELETE (SOFT)
    public function destroy($id)
    {
        $record = PayrollResultEarning::findOrFail($id);
        if ($record->payrollResult && $record->payrollResult->status === 'finalized') {
        return redirect()->back()->with('error', 'Cannot delete after payroll finalization.');
    }
        $record->delete();

        return redirect()->back()->with('success', 'Deleted');
    }

    // DELETED LIST
    public function deleted()
    {
        $records = PayrollResultEarning::onlyTrashed()->get();
        return view('hr.payroll.payroll_result_earnings.deleted', compact('records'));
    }

    // RESTORE
    public function restore($id)
    {
        $record = PayrollResultEarning::onlyTrashed()->findOrFail($id);
        $record->restore();

        return redirect()->back()->with('success', 'Restored');
    }

    // FORCE DELETE
    public function forceDelete($id)
    {
        $record = PayrollResultEarning::onlyTrashed()->findOrFail($id);
        $record->forceDelete();

        return redirect()->back()->with('success', 'Permanently Deleted');
    }



    //api methods
    public function apiIndex()
{
    $records = PayrollResultEarning::latest()->get();

    return response()->json([
        'status' => true,
        'data' => $records
    ]);
}public function apiShow($id)
{
    $record = PayrollResultEarning::find($id);

    if (!$record) {
        return response()->json([
            'status' => false,
            'message' => 'Not found'
        ], 404);
    }

    return response()->json([
        'status' => true,
        'data' => $record
    ]);
}public function apiStore(Request $request)
{
    $request->validate([
        'payroll_result_id' => 'required',
        'earning_code' => 'required',
        'earning_name' => 'required',
        'earning_type' => 'required',
        'amount' => 'required|numeric|min:0',
        'calculation_base' => 'required_if:earning_type,Variable,OT',
        'calculation_value' => 'required_if:earning_type,Variable,OT|nullable|numeric|min:0',
    ]);

    $record = PayrollResultEarning::create([
        ...$request->all(),
        'created_by' => Auth::id()
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Created successfully',
        'data' => $record
    ], 201);
}public function apiUpdate(Request $request, $id)
{
    $record = PayrollResultEarning::find($id);

    if (!$record) {
        return response()->json([
            'status' => false,
            'message' => 'Not found'
        ], 404);
    }

    $request->validate([
        'earning_code' => 'required',
        'earning_name' => 'required',
        'earning_type' => 'required',
        'amount' => 'required|numeric|min:0',
        'calculation_base' => 'required_if:earning_type,Variable,OT',
        'calculation_value' => 'required_if:earning_type,Variable,OT|nullable|numeric|min:0',
    ]);

    $record->update($request->all());

    return response()->json([
        'status' => true,
        'message' => 'Updated successfully',
        'data' => $record
    ]);
}public function apiDelete($id)
{
    $record = PayrollResultEarning::find($id);

    if (!$record) {
        return response()->json([
            'status' => false,
            'message' => 'Not found'
        ], 404);
    }

    $record->delete();

    return response()->json([
        'status' => true,
        'message' => 'Deleted successfully'
    ]);
}
}