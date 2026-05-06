<?php

namespace App\Http\Controllers\HR\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PayrollResultEarning;
use App\Models\PayrollResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PayrollResultEarningController extends Controller
{
    // INDEX
    public function index()
    {
        $records = PayrollResultEarning::with('payrollResult')
            ->latest()
            ->paginate(10);

        return view(
            'hr.payroll.payroll_result_earnings.index',
            compact('records')
        );
    }

    // CREATE
    public function create()
    {
        $payrollResults = PayrollResult::orderBy('created_on', 'desc')->get();

        return view(
            'hr.payroll.payroll_result_earnings.create',
            compact('payrollResults')
        );
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([

            'payroll_result_id' => [
                'required',
                'exists:payroll_results,id'
            ],

            'earning_code' => [
                'required',

                Rule::unique('payroll_result_earnings')
                    ->where(function ($query) use ($request) {

                        return $query->where(
                            'payroll_result_id',
                            $request->payroll_result_id
                        );
                    })
            ],

            'earning_name' => 'required',

            'earning_type' => 'required',

            'amount' => 'required|numeric|min:0',

            'calculation_base' =>
                'required_if:earning_type,Variable,OT|nullable',

            'calculation_value' =>
                'required_if:earning_type,Variable,OT|nullable|numeric|min:0',
        ]);

        // BLOCK unnecessary calculation fields for Fixed
        if (
            $request->earning_type === 'Fixed' &&
            (
                $request->filled('calculation_base') ||
                $request->filled('calculation_value')
            )
        ) {

            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'calculation_base' =>
                        'Calculation fields are not needed for Fixed earnings.'
                ]);
        }

        // CREATE
        PayrollResultEarning::create([

            ...$request->all(),

            'created_by' => Auth::id()
        ]);

        return redirect()
            ->route('hr.payroll.payroll-result-earnings.index')
            ->with('success', 'Earning added successfully');
    }

    // SHOW
    public function show($id)
    {
        $record = PayrollResultEarning::with('payrollResult')
            ->findOrFail($id);

        return view(
            'hr.payroll.payroll_result_earnings.show',
            compact('record')
        );
    }

    // EDIT
    public function edit($id)
    {
        $record = PayrollResultEarning::with('payrollResult')
            ->findOrFail($id);

        // BLOCK finalized payroll edits
        if (
            $record->payrollResult &&
            strtolower($record->payrollResult->status) === 'finalized'
        ) {

            return redirect()->back()
                ->with('error', 'Cannot edit after payroll finalization.');
        }

       $payrollResults = PayrollResult::orderBy('created_on', 'desc')->get();

        return view(
            'hr.payroll.payroll_result_earnings.edit',
            compact('record', 'payrollResults')
        );
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $record = PayrollResultEarning::findOrFail($id);

        // BLOCK finalized payroll edits
        if (
            $record->payrollResult &&
            strtolower($record->payrollResult->status) === 'finalized'
        ) {

            return redirect()->back()
                ->with('error', 'Cannot edit after payroll finalization.');
        }

        $request->validate([

            'payroll_result_id' => [
                'required',
                'exists:payroll_results,id'
            ],

            'earning_code' => [

                'required',

                Rule::unique('payroll_result_earnings')
                    ->ignore($record->id)
                    ->where(function ($query) use ($request) {

                        return $query->where(
                            'payroll_result_id',
                            $request->payroll_result_id
                        );
                    })
            ],

            'earning_name' => 'required',

            'earning_type' => 'required',

            'amount' => 'required|numeric|min:0',

            'calculation_base' =>
                'required_if:earning_type,Variable,OT|nullable',

            'calculation_value' =>
                'required_if:earning_type,Variable,OT|nullable|numeric|min:0',
        ]);

        // BLOCK unnecessary calculation fields for Fixed
        if (
            $request->earning_type === 'Fixed' &&
            (
                $request->filled('calculation_base') ||
                $request->filled('calculation_value')
            )
        ) {

            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'calculation_base' =>
                        'Calculation fields are not needed for Fixed earnings.'
                ]);
        }

        $record->update($request->all());

        return redirect()
            ->route('hr.payroll.payroll-result-earnings.index')
            ->with('success', 'Updated successfully');
    }

    // DELETE
    public function destroy($id)
    {
        $record = PayrollResultEarning::with('payrollResult')
            ->findOrFail($id);

        // BLOCK finalized payroll deletion
        if (
            $record->payrollResult &&
            strtolower($record->payrollResult->status) === 'finalized'
        ) {

            return redirect()->back()
                ->with('error', 'Cannot delete after payroll finalization.');
        }

        $record->delete();

        return redirect()->back()
            ->with('success', 'Deleted successfully');
    }




    //api methods
public function apiIndex()
{
    $records = PayrollResultEarning::with('payrollResult')
        ->latest()
        ->get();

    return response()->json([
        'status' => true,
        'data' => $records
    ]);
}
public function apiShow($id)
{
    $record = PayrollResultEarning::with('payrollResult')->find($id);

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
}

public function apiStore(Request $request)
{
    $request->validate([

        'payroll_result_id' => [
            'required',
            'exists:payroll_results,id'
        ],

        'earning_code' => [
            'required',

            Rule::unique('payroll_result_earnings')
                ->where(function ($query) use ($request) {
                    return $query->where(
                        'payroll_result_id',
                        $request->payroll_result_id
                    );
                })
        ],

        'earning_name' => 'required',
        'earning_type' => 'required',
        'amount' => 'required|numeric|min:0',

        'calculation_base' =>
            'required_if:earning_type,Variable,OT|nullable',

        'calculation_value' =>
            'required_if:earning_type,Variable,OT|nullable|numeric|min:0',
    ]);

    // FIXED type restriction
    if (
        $request->earning_type === 'Fixed' &&
        (
            $request->filled('calculation_base') ||
            $request->filled('calculation_value')
        )
    ) {
        return response()->json([
            'status' => false,
            'message' => 'Calculation fields not allowed for Fixed'
        ], 422);
    }

    $record = PayrollResultEarning::create([
        ...$request->all(),
        'created_by' => Auth::id()
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Created successfully',
        'data' => $record
    ], 201);
}

public function apiUpdate(Request $request, $id)
{
    $record = PayrollResultEarning::with('payrollResult')->find($id);

    if (!$record) {
        return response()->json([
            'status' => false,
            'message' => 'Not found'
        ], 404);
    }

    // BLOCK finalized payroll edits
    if (
        $record->payrollResult &&
        strtolower($record->payrollResult->status) === 'finalized'
    ) {
        return response()->json([
            'status' => false,
            'message' => 'Cannot edit after payroll finalization'
        ], 422);
    }

    $request->validate([

        'payroll_result_id' => [
            'required',
            'exists:payroll_results,id'
        ],

        'earning_code' => [

            'required',

            Rule::unique('payroll_result_earnings')
                ->ignore($record->id)
                ->where(function ($query) use ($request) {
                    return $query->where(
                        'payroll_result_id',
                        $request->payroll_result_id
                    );
                })
        ],

        'earning_name' => 'required',
        'earning_type' => 'required',
        'amount' => 'required|numeric|min:0',

        'calculation_base' =>
            'required_if:earning_type,Variable,OT|nullable',

        'calculation_value' =>
            'required_if:earning_type,Variable,OT|nullable|numeric|min:0',
    ]);

    // FIXED restriction
    if (
        $request->earning_type === 'Fixed' &&
        (
            $request->filled('calculation_base') ||
            $request->filled('calculation_value')
        )
    ) {
        return response()->json([
            'status' => false,
            'message' => 'Calculation fields not allowed for Fixed'
        ], 422);
    }

    $record->update($request->all());

    return response()->json([
        'status' => true,
        'message' => 'Updated successfully',
        'data' => $record
    ]);
}


public function apiDelete($id)
{
    $record = PayrollResultEarning::with('payrollResult')->find($id);

    if (!$record) {
        return response()->json([
            'status' => false,
            'message' => 'Not found'
        ], 404);
    }

    // BLOCK finalized payroll delete
    if (
        $record->payrollResult &&
        strtolower($record->payrollResult->status) === 'finalized'
    ) {
        return response()->json([
            'status' => false,
            'message' => 'Cannot delete after payroll finalization'
        ], 422);
    }

    $record->delete();

    return response()->json([
        'status' => true,
        'message' => 'Deleted successfully'
    ]);
}
}