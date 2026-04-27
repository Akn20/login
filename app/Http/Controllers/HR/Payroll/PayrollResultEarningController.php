<?php
namespace App\Http\Controllers\HR\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PayrollResultEarning;
use Illuminate\Support\Facades\Auth;

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
            'earning_code' => 'required',
            'earning_name' => 'required',
            'earning_type' => 'required',
            'amount' => 'required|numeric|min:0',
        ]);

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
        return view('hr.payroll.payroll_result_earnings.edit', compact('record'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $record = PayrollResultEarning::findOrFail($id);

        $request->validate([
            'earning_code' => 'required',
            'earning_name' => 'required',
            'earning_type' => 'required',
            'amount' => 'required|numeric|min:0',
        ]);

        $record->update($request->all());

        return redirect()->route('hr.payroll.payroll-result-earnings.index')
            ->with('success', 'Updated successfully');
    }

    // DELETE (SOFT)
    public function destroy($id)
    {
        $record = PayrollResultEarning::findOrFail($id);
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
}