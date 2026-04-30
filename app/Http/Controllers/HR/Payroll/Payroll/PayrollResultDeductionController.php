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
}