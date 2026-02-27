<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffManagementController extends Controller
{
    public function index()
    {
        $staffManagements = Staff::latest()->paginate(10);

        return view('hr.staff_management.index', compact('staffManagements'));
    }

    public function create()
    {
        return view('hr.staff_management.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|unique:staff,employee_id',
            'name' => 'required',
            'joining_date' => 'required|date',
            'status' => 'required',
        ]);

        Staff::create([
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'joining_date' => $request->joining_date,
            'status' => $request->status,
        ]);

        return redirect()->route('hr.staff-management.index')
            ->with('success', 'Staff added successfully.');
    }

    public function edit($id)
    {
        $staff = Staff::findOrFail($id);

        return view('hr.staff_management.edit', compact('staff'));
    }

    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $request->validate([
            'employee_id' => 'required|unique:staff,employee_id,'.$id,
            'name' => 'required',
            'joining_date' => 'required|date',
            'status' => 'required',
        ]);

        $staff->update([
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'joining_date' => $request->joining_date,
            'status' => $request->status,
        ]);

        return redirect()->route('hr.staff-management.index')
            ->with('success', 'Staff updated successfully.');
    }

    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);
        $staff->delete();

        return redirect()->route('hr.staff-management.index')
            ->with('success', 'Staff deleted successfully.');
    }

    public function deleted()
    {
        $staffs = Staff::onlyTrashed()->latest()->paginate(10);

        return view('hr.staff_management.deleted', compact('staffs'));
    }

    public function restore($id)
    {
        $staff = Staff::onlyTrashed()->findOrFail($id);
        $staff->restore();

        return redirect()->route('hr.staff-management.deleted')
            ->with('success', 'Staff restored successfully.');
    }

    public function forceDelete($id)
    {
        $staff = Staff::onlyTrashed()->findOrFail($id);
        $staff->forceDelete();

        return redirect()->route('hr.staff-management.deleted')
            ->with('success', 'Staff permanently deleted.');
    }
}
