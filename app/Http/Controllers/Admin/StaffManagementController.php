<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;

class StaffManagementController extends Controller
{
    public function index()
    {
        $staffManagements = Staff::latest()->paginate(10);
        return view('admin.hr.staff_management.index', compact('staffManagements'));
    }

    public function create()
    {
        return view('admin.hr.staff_management.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|unique:staff,employee_id',
            'name' => 'required',
            'joining_date' => 'required|date',
            'status' => 'required'
        ]);

        Staff::create([
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'joining_date' => $request->joining_date,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.staff-management.index')
            ->with('success', 'Staff added successfully.');
    }

    public function edit($id)
    {
        $staff = Staff::findOrFail($id);
        return view('admin.hr.staff_management.edit', compact('staff'));
    }

    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $request->validate([
            'employee_id' => 'required|unique:staff,employee_id,' . $id,
            'name' => 'required',
            'joining_date' => 'required|date',
            'status' => 'required'
        ]);

        $staff->update([
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'joining_date' => $request->joining_date,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.staff-management.index')
            ->with('success', 'Staff updated successfully.');
    }

    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);
        $staff->delete();

        return redirect()->route('admin.staff-management.index')
            ->with('success', 'Staff deleted successfully.');
    }
}