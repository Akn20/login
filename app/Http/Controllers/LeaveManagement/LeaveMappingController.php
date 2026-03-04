<?php

namespace App\Http\Controllers\LeaveManagement;

use App\Http\Controllers\Controller;
use App\Models\LeaveMapping;
use App\Models\LeaveType; 
use Illuminate\Http\Request;

class LeaveMappingController extends Controller
{
    public function index()
    {
        $mappings = LeaveMapping::with('leaveType')->get();
        return view('admin.Leave_Management.leave_mappings.index', compact('mappings'));
    }

   public function create()
{
    $leaveTypes = \App\Models\LeaveType::all();
    // Fetch unique designation strings currently assigned to staff
    $designations = \App\Models\Staff::distinct()->pluck('designation'); 
    
    return view('admin.Leave_Management.leave_mappings.create', compact('leaveTypes', 'designations'));
}

public function store(Request $request)
{
    $request->merge([
        'status' => $request->has('status') ? 'active' : 'inactive',
        'carry_forward_allowed' => $request->has('carry_forward_allowed'),
    ]);

    $data = $request->validate([
        'leave_type_id' => 'required|uuid',
        'priority' => 'required|integer',
        'employee_status' => 'required|array', 
        'designations' => 'required|array', // New validation
        'accrual_frequency' => 'required|in:Monthly,Yearly,Event Based', 
        'accrual_value' => 'required|integer',
        'leave_nature' => 'required|in:Paid,Unpaid',
        'status' => 'required|in:active,inactive',
    ]);

    \App\Models\LeaveMapping::create($data);

    return redirect()->route('admin.leave-mappings.index')->with('success', 'Mapping created!');
}
    public function edit($id)
    {
        $mapping = LeaveMapping::findOrFail($id);
        $leaveTypes = LeaveType::all(); 
        return view('admin.Leave_Management.leave_mappings.edit', compact('mapping', 'leaveTypes'));
    }

   public function update(Request $request, $id)
{
    $mapping = LeaveMapping::findOrFail($id);
    
    // Sync checkboxes
    $request->merge([
        'status' => $request->has('status') ? 'active' : 'inactive',
        'carry_forward_allowed' => $request->has('carry_forward_allowed'),
    ]);

    $data = $request->validate([
        'leave_type_id' => 'required|uuid',
        'priority' => 'required|integer',
        'employee_status' => 'required|array', 
        'accrual_frequency' => 'required|in:Monthly,Yearly,Event Based', 
        'accrual_value' => 'required|integer',
        'leave_nature' => 'required|in:Paid,Unpaid',
        'status' => 'required|in:active,inactive',
    ]);

    $mapping->update($data);

    return redirect()->route('admin.leave-mappings.index')->with('success', 'Mapping updated successfully!');
}
    public function destroy($id)
    {
        LeaveMapping::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Moved to trash');
    }

    public function deleted() {
        $mappings = LeaveMapping::onlyTrashed()->with('leaveType')->get(); 
        return view('admin.Leave_Management.leave_mappings.deleted', compact('mappings'));
    }

    public function restore($id) {
        LeaveMapping::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.leave-mappings.index')->with('success', 'Restored');
    }
    public function forceDelete($id)
    {
        // Find the record even if it is in the trash
        $mapping = LeaveMapping::withTrashed()->findOrFail($id);
        
        // Permanently delete from the database
        $mapping->forceDelete();

        return redirect()->route('admin.leave-mappings.deleted')->with('success', 'Record permanently deleted.');
    }
    public function show($id)
    {
        $mapping = LeaveMapping::with('leaveType')->findOrFail($id);
        return view('admin.Leave_Management.leave_mappings.show', compact('mapping'));
    }
}