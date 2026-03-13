<?php

namespace App\Http\Controllers\LeaveManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompOff;
use App\Models\Staff;
use Illuminate\Support\Str;

class CompOffController extends Controller
{

    public function index()
    {
        $compoffs = CompOff::with('employee')->latest()->get();

        return view('admin.Leave_Management.compoffs.index', compact('compoffs'));
    }

    public function create()
    {
        $employees = Staff::where('status', 'Active')->orderBy('name')->get();

        return view('admin.Leave_Management.compoffs.form', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'       => 'required|exists:staff,id',
            'worked_on'         => 'required|date',
            'comp_off_credited' => 'required|numeric|min:0.1',
            'expiry_date'       => 'nullable|date|after_or_equal:worked_on',
        ]);

        CompOff::create([
            'id'                => Str::uuid(),
            'employee_id'       => $request->employee_id,
            'worked_on'         => $request->worked_on,
            'comp_off_credited' => $request->comp_off_credited,
            'expiry_date'       => $request->expiry_date,
        ]);

        return redirect()
            ->route('hr.compoffs.index')
            ->with('success', 'Comp-Off created successfully');
    }

    public function edit($id)
    {
        $compoff   = CompOff::findOrFail($id);
        $employees = Staff::where('status', 'Active')->orderBy('name')->get();

        return view('admin.Leave_Management.compoffs.form', compact('compoff', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_id'       => 'required|exists:staff,id',
            'worked_on'         => 'required|date',
            'comp_off_credited' => 'required|numeric|min:0.1',
            'expiry_date'       => 'nullable|date|after_or_equal:worked_on',
        ]);

        $compoff = CompOff::findOrFail($id);

        $compoff->update([
            'employee_id'       => $request->employee_id,   // ✅ was missing
            'worked_on'         => $request->worked_on,
            'comp_off_credited' => $request->comp_off_credited,
            'expiry_date'       => $request->expiry_date,
        ]);

        return redirect()
            ->route('hr.compoffs.index')
            ->with('success', 'Comp-Off updated successfully');
    }

    public function destroy($id)
    {
        CompOff::findOrFail($id)->delete();

        return redirect()
            ->route('hr.compoffs.index')
            ->with('success', 'Comp-Off deleted successfully');
    }

    public function deleted()
    {
        $compoffs = CompOff::onlyTrashed()->get();

        return view('admin.Leave_Management.compoffs.deleted', compact('compoffs'));
    }

    public function restore($id)
    {
        CompOff::onlyTrashed()->where('id', $id)->restore();

        return redirect()
            ->route('hr.compoffs.deleted')
            ->with('success', 'Comp-Off restored successfully');
    }

    public function forceDelete($id)
    {
        CompOff::onlyTrashed()->where('id', $id)->forceDelete();

        return redirect()
            ->route('hr.compoffs.deleted')
            ->with('success', 'Comp-Off permanently deleted');
    }
}