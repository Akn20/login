<?php

namespace App\Http\Controllers\LeaveManagement;

use App\Http\Controllers\Controller;
use App\Models\LeaveMapping;
use App\Models\LeaveType; 
use Illuminate\Http\Request;
use App\Models\Designation; 
use Illuminate\Support\Facades\DB;

class LeaveMappingController extends Controller
{
 
     public function index()
    {
        // 1. Fetch mappings with eager loading for Leave Type names
        // Note: Using 'mappings' as the variable name to match your existing index file
        $mappings = LeaveMapping::with('leaveType')->latest()->paginate(10);
        
        // 2. Fetch the map of ID => Name from the Designation Master table
        // This converts the UUIDs in your database into names like 'anaesthetist'
        $designationMap = Designation::pluck('designation_name', 'id');

        return view('admin.Leave_Management.leave_mappings.index', compact('mappings', 'designationMap'));
    }
 public function create()
{
    $leaveTypes = \App\Models\LeaveType::all();
    
    // Updated to use 'designation_name' instead of 'name'
    $designations = \App\Models\Designation::orderBy('designation_name', 'asc')->get(); 
    
    return view('admin.Leave_Management.leave_mappings.create', compact('leaveTypes', 'designations'));
}

public function store(Request $request)
{
    // Normalize input arrays for comparison
    $inputDesignations = is_array($request->designations)
        ? $request->designations
        : [$request->designations];
    $inputStatus = is_array($request->employee_status)
        ? $request->employee_status
        : [$request->employee_status];

    sort($inputDesignations);
    sort($inputStatus);

    // Fetch all non-deleted mappings for the same leave_type_id
    // then compare JSON-decoded designations and employee_status in PHP
    $existingMappings = DB::table('leave_mappings')
        ->where('leave_type_id', $request->leave_type_id)
        ->whereNull('deleted_at')
        ->get();

    foreach ($existingMappings as $mapping) {
        $dbDesignations = json_decode($mapping->designations, true) ?? [];
        $dbStatus       = json_decode($mapping->employee_status, true) ?? [];

        sort($dbDesignations);
        sort($dbStatus);

        if ($dbDesignations === $inputDesignations && $dbStatus === $inputStatus) {
            return redirect()->back()
                ->withInput()
                ->with('error_message', 'A mapping for this Leave Type, Employee Status, and Designation combination already exists!');
        }
    }


  

    // ... continue to validation and LeaveMapping::create($data) ...

    // Sync checkboxes to boolean values
    $request->merge([
        'status' => $request->has('status') ? 'active' : 'inactive',
        'carry_forward_allowed' => $request->has('carry_forward_allowed'),
        'encashment_allowed' => $request->has('encashment_allowed'), // New
    ]);

    $data = $request->validate([
        'leave_type_id' => 'required|uuid',
        'priority' => 'required|integer',
        'employee_status' => 'required|array', 
        'designations' => 'required', // Now handles IDs from Designation Master
        'accrual_frequency' => 'required|in:Monthly,Yearly,Event Based', 
        'accrual_value' => 'required|integer',
        'leave_nature' => 'required|in:Paid,Unpaid',
        'status' => 'required|in:active,inactive',
        // Encashment Validation
        'encashment_allowed' => 'boolean',
        'encashment_trigger' => 'nullable|string|in:Year-end,Exit,Specific Date',
        // Carry Forward Validation
        'carry_forward_allowed' => 'boolean',
        'carry_forward_limit' => 'nullable|integer',
        'carry_forward_expiry_days' => 'nullable|integer',
        'min_leave_per_application' => 'required|integer|min:1', 
    'max_leave_per_application' => 'nullable|integer|gte:min_leave_per_application',
    ],[ 
        // Fixed: added a comma between the two arrays
        'max_leave_per_application.gte' => 'The maximum leave must be greater than or equal to the minimum leave per application.',
    ]
    );
     if (isset($data['designations']) && !is_array($data['designations'])) {
            $data['designations'] = [$data['designations']];
        }

        LeaveMapping::create($data);

        return redirect()->route('hr.leave-mappings.index')->with('success', 'Mapping created successfully!');
    }

    public function edit($id)
    {
        $mapping = LeaveMapping::findOrFail($id);
        $leaveTypes = LeaveType::all();
        
        // Fix: Fetch the designations here as well so the edit form doesn't crash
        $designations = Designation::orderBy('designation_name', 'asc')->get();
        
        return view('admin.Leave_Management.leave_mappings.edit', compact('mapping', 'leaveTypes', 'designations'));
    }
public function show($id)
    {
        // Eager load for the detail view to prevent blank fields
        $mapping = LeaveMapping::with('leaveType')->findOrFail($id);
        
        // Fetch designation map to show names in show.blade.php
        $designationMap = Designation::pluck('designation_name', 'id');
        
        return view('admin.Leave_Management.leave_mappings.show', compact('mapping', 'designationMap'));
    }


   public function update(Request $request, $id)
{
    $mapping = \App\Models\LeaveMapping::findOrFail($id);

    // Duplicate check — same logic as store(), but exclude the current record
    $inputDesignations = is_array($request->designations)
        ? $request->designations
        : [$request->designations];
    $inputStatus = is_array($request->employee_status)
        ? $request->employee_status
        : [$request->employee_status];

    sort($inputDesignations);
    sort($inputStatus);

    $existingMappings = DB::table('leave_mappings')
        ->where('leave_type_id', $request->leave_type_id)
        ->where('id', '!=', $id)          // exclude current record
        ->whereNull('deleted_at')
        ->get();

    foreach ($existingMappings as $existing) {
        $dbDesignations = json_decode($existing->designations, true) ?? [];
        $dbStatus       = json_decode($existing->employee_status, true) ?? [];

        sort($dbDesignations);
        sort($dbStatus);

        if ($dbDesignations === $inputDesignations && $dbStatus === $inputStatus) {
            return redirect()->back()
                ->withInput()
                ->with('error_message', 'A mapping for this Leave Type, Employee Status, and Designation combination already exists!');
        }
    }

    $request->merge([
        'status' => $request->has('status') ? 'active' : 'inactive',
        'carry_forward_allowed' => $request->has('carry_forward_allowed'),
        'encashment_allowed' => $request->has('encashment_allowed'),
    ]);

    $data = $request->validate([
        'leave_type_id' => 'required|uuid',
        'priority' => 'required|integer',
        'employee_status' => 'required|array', 
        'designations' => 'required', 
        // Fixed: removed the space in 'accrual_frequency'
        'accrual_frequency' => 'required|in:Monthly,Yearly,Event Based', 
        'accrual_value' => 'required|integer',
        'leave_nature' => 'required|in:Paid,Unpaid',
        'status' => 'required|in:active,inactive',
        'encashment_allowed' => 'boolean',
        'encashment_trigger' => 'nullable|string',
        'carry_forward_allowed' => 'boolean',
        'carry_forward_limit' => 'nullable|integer',
        'min_leave_per_application' => 'required|integer|min:1', 
        // Fixed: added the comma at the end of this line
        'max_leave_per_application' => 'nullable|integer|gte:min_leave_per_application',
    ], [ 
        // Fixed: added a comma between the two arrays
        'max_leave_per_application.gte' => 'The maximum leave must be greater than or equal to the minimum leave per application.',
    ]);
   if (isset($data['designations']) && !is_array($data['designations'])) {
            $data['designations'] = [$data['designations']];
        }

        $mapping->update($data);

        return redirect()->route('hr.leave-mappings.index')->with('success', 'Mapping updated successfully!');
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
    public function forceDelete($id)
{
    // Finds the record even if it is in the trash and deletes it forever
    LeaveMapping::withTrashed()->findOrFail($id)->forceDelete();
    
    return redirect()->back()->with('success', 'Mapping permanently deleted');
}

    public function restore($id) {
        LeaveMapping::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('hr.leave-mappings.index')->with('success', 'Restored');
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
        'designations' => 'required',

        'accrual_frequency' => 'required|in:Monthly,Yearly,Event Based',
        'accrual_value' => 'required|integer',

        'leave_nature' => 'required|in:Paid,Unpaid',

        'carry_forward_allowed' => 'nullable|boolean',
        'carry_forward_limit' => 'nullable|integer',
        'carry_forward_expiry_days' => 'nullable|integer',

        'min_leave_per_application' => 'nullable|integer',
        'max_leave_per_application' => 'nullable|integer',

        'status' => 'required|in:active,inactive',
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
    'designations' => 'sometimes|array',

    'accrual_frequency' => 'sometimes|in:Monthly,Yearly,Event Based',
    'accrual_value' => 'sometimes|integer',

    'leave_nature' => 'sometimes|in:Paid,Unpaid',

    'carry_forward_allowed' => 'nullable|boolean',
    'carry_forward_limit' => 'nullable|integer',
    'carry_forward_expiry_days' => 'nullable|integer',

    'min_leave_per_application' => 'nullable|integer',
    'max_leave_per_application' => 'nullable|integer',

    'status' => 'sometimes|in:active,inactive',
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