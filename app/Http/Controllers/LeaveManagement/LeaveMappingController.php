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
        $leaveTypes = LeaveType::all(); 
        return view('admin.Leave_Management.leave_mappings.create', compact('leaveTypes'));
    }

   public function store(Request $request)
{
    // Sync status checkbox
    $request->merge(['status' => $request->has('status') ? 'active' : 'inactive']);
    
    // Handle checkboxes that might be missing from the request
    $request->merge([
        'carry_forward_allowed' => $request->has('carry_forward_allowed'),
        'encashment_allowed' => $request->has('encashment_allowed'),
    ]);

    $data = $request->validate([
        'leave_type_id' => 'required|uuid',
        'priority' => 'required|integer',
        'employee_status' => 'required|array', 
        'accrual_frequency' => 'required|in:Monthly,Yearly,Event Based', 
        'accrual_value' => 'required|integer', // This fixes the error
        'leave_nature' => 'required|in:Paid,Unpaid',
        'status' => 'required|in:active,inactive',
        'carry_forward_allowed' => 'boolean',
        'carry_forward_limit' => 'nullable|integer',
        'carry_forward_expiry_days' => 'nullable|integer',
        'min_leave_per_application' => 'nullable|integer',
        'max_leave_per_application' => 'nullable|integer',
    ]);

    LeaveMapping::create($data);

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


    // ================== API METHODS ==================

public function apiIndex()
{
    $mappings = LeaveMapping::with('leaveType')->get();

    return response()->json([
        'status' => true,
        'data' => $mappings
    ]);
}

public function apiShow($id)
{
    $mapping = LeaveMapping::with('leaveType')->find($id);

    if (!$mapping) {
        return response()->json([
            'status' => false,
            'message' => 'Mapping not found'
        ], 404);
    }

    return response()->json([
        'status' => true,
        'data' => $mapping
    ]);
}

public function apiStore(Request $request)
{
    $data = $request->validate([
        'leave_type_id' => 'required|uuid',
        'priority' => 'required|integer',
        'employee_status' => 'required|array',
        'accrual_frequency' => 'required|in:Monthly,Yearly,Event Based',
        'accrual_value' => 'required|integer',
        'leave_nature' => 'required|in:Paid,Unpaid',
    ]);

    $mapping = LeaveMapping::create($data);

    return response()->json([
        'status' => true,
        'message' => 'Mapping created successfully',
        'data' => $mapping
    ]);
}

public function apiUpdate(Request $request, $id)
{
    $mapping = LeaveMapping::find($id);

    if (!$mapping) {
        return response()->json([
            'status' => false,
            'message' => 'Mapping not found'
        ], 404);
    }

   $data = $request->validate([
    'leave_type_id' => 'sometimes|uuid',
    'priority' => 'sometimes|integer',
    'employee_status' => 'sometimes|array',
    'accrual_frequency' => 'sometimes|in:Monthly,Yearly,Event Based',
    'accrual_value' => 'sometimes|integer',
    'leave_nature' => 'sometimes|in:Paid,Unpaid',
]);

    $mapping->update($data);

    return response()->json([
        'status' => true,
        'message' => 'Mapping updated successfully',
        'data' => $mapping
    ]);
}

public function apiDestroy($id)
{
    $mapping = LeaveMapping::find($id);

    if (!$mapping) {
        return response()->json([
            'status' => false,
            'message' => 'Mapping not found'
        ], 404);
    }

    $mapping->delete();

    return response()->json([
        'status' => true,
        'message' => 'Mapping deleted successfully'
    ]);
}
public function apiDeleted()
{
    $mappings = LeaveMapping::onlyTrashed()
                    ->with('leaveType')
                    ->get();

    return response()->json([
        'status' => true,
        'data' => $mappings
    ]);
}
public function apiRestore($id)
{
    $mapping = LeaveMapping::onlyTrashed()->find($id);

    if (!$mapping) {
        return response()->json([
            'status' => false,
            'message' => 'Mapping not found'
        ], 404);
    }

    $mapping->restore();

    return response()->json([
        'status' => true,
        'message' => 'Mapping restored successfully'
    ]);
}

public function apiForceDelete($id)
{
    $mapping = LeaveMapping::onlyTrashed()->find($id);

    if (!$mapping) {
        return response()->json([
            'status' => false,
            'message' => 'Mapping not found'
        ], 404);
    }

    $mapping->forceDelete();

    return response()->json([
        'status' => true,
        'message' => 'Mapping permanently deleted'
    ]);
}

}