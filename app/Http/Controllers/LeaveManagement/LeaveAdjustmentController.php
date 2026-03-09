<?php

namespace App\Http\Controllers\LeaveManagement;

use App\Http\Controllers\Controller;
use App\Models\LeaveAdjustment;
use App\Models\Staff;
use App\Models\LeaveType;
use App\Models\LeaveMapping;//add this
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class LeaveAdjustmentController extends Controller
{

//  public function index()
// {
//     $adjustments = LeaveAdjustment::with(['staff','leaveType'])->get();

//     return view(
//         'admin.Leave_Management.leave_adjustments.index',
//         compact('adjustments')
//     );
// }
public function index(Request $request)
{
    // Start query with relationships
    $query = LeaveAdjustment::with(['staff','leaveType']);

    // Filter by staff
    if ($request->staff_id) {
        $query->where('staff_id', $request->staff_id);
    }

    // Get results (latest first)
    $adjustments = $query->latest()->get();

    // Get staff list for dropdown
    $staff = Staff::select('id','name')->get();

    // Return view
    return view(
        'admin.Leave_Management.leave_adjustments.index',
        compact('adjustments','staff')
    );
}
public function create()
{
    $staff = Staff::select('id','name','designation_id')->get();
    $leaveTypes = LeaveType::all();

    return view(
        'admin.Leave_Management.leave_adjustments.create',
        compact('staff','leaveTypes')
    );
}
// public function store(Request $request)

// {dd($request->all());
//     $data = $request->validate([
//         'staff_id' => 'required|uuid',
//         'leave_type_id' => 'required|uuid',
//         'credit' => 'nullable|integer',
//         'debit' => 'nullable|integer',
//         'year' => 'required|integer',
//         'remarks' => 'nullable|string',
//     ]);

//     LeaveAdjustment::create($data);

//     return redirect()
//         ->route('admin.leave-adjustments.index')
//         ->with('success','Leave adjustment created successfully');
// }



public function store(Request $request)
{
    // $request->validate([
    //     'staff_id' => 'required',
    //     'leave_type_id' => 'required|array',
    //     'credit' => 'nullable|array',
    //     'debit' => 'nullable|array',
    //     'year' => 'required',
    //     'remarks' => 'nullable|string',
    // ]);
    $request->validate([
    'staff_id' => 'required',
    'leave_type_id' => 'required|array',
    'leave_type_id.*' => 'required',
    'credit.*' => 'nullable|integer|min:0',
    'debit.*' => 'nullable|integer|min:0',
    'year' => 'required|integer',
    'remarks' => 'nullable|string',
]);

    foreach ($request->leave_type_id as $index => $leaveTypeId) {

        $credit = $request->credit[$index] ?? 0;
        $debit  = $request->debit[$index] ?? 0;

        // skip empty rows
        if ($credit == 0 && $debit == 0) {
            continue;
        }

        LeaveAdjustment::create([
            'id' => Str::uuid(),
            'staff_id' => $request->staff_id,
            'leave_type_id' => $leaveTypeId,
            'credit' => $credit,
            'debit' => $debit,
            'year' => $request->year,
            'remarks' => $request->remarks,
        ]);
    }

    return redirect()
        ->route('admin.leave-adjustments.index')
        ->with('success','Leave adjustment created successfully');
}
/*public function getLeaveMapping($staffId)
{
    $staff = Staff::find($staffId);

    if (!$staff) {
        return response()->json([]);
    }

    $designationId = $staff->designation_id;

    $mappings = \App\Models\LeaveMapping::whereJsonContains('designations', (string)$designationId)
        ->with('leaveType')
        ->get();

    foreach ($mappings as $mapping) {

        $credit = LeaveAdjustment::where('staff_id', $staffId)
            ->where('leave_type_id', $mapping->leave_type_id)
            ->sum('credit');

        $debit = LeaveAdjustment::where('staff_id', $staffId)
            ->where('leave_type_id', $mapping->leave_type_id)
            ->sum('debit');

        $mapping->current_balance = $mapping->accrual_value + $credit - $debit;
    }

    return response()->json($mappings);
}*/


public function show($id)
{
    $adjustment = LeaveAdjustment::with(['staff','leaveType'])->findOrFail($id);

    return view(
        'admin.Leave_Management.leave_adjustments.show',
        compact('adjustment')
    );
}
 /**
     * API: Get list of adjustments
     */
    public function apiIndex(Request $request)
    {
        $query = LeaveAdjustment::with(['staff', 'leaveType']);

        if ($request->staff_id) {
            $query->where('staff_id', $request->staff_id);
        }

        $adjustments = $query->latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => $adjustments
        ]);
    }

    /**
     * API: Fetch Leave Mapping & Current Balances for an Employee
     * This handles the "Default" values based on Designation
     */
    public function getLeaveMapping($staffId)
    {
        $staff = Staff::find($staffId);

        if (!$staff) {
            return response()->json(['message' => 'Staff not found'], 404);
        }

        $designationId = (string) $staff->designation_id;

        // Fetch mappings where this staff's designation is included
        // Using whereJsonContains for arrays, or simple where for single value
        $mappings = LeaveMapping::whereJsonContains('designations', $designationId)
            ->orWhere('designations', $designationId) 
            ->with('leaveType')
            ->get();

        foreach ($mappings as $mapping) {
            // Calculate Sum of Credits and Debits for this staff
            $credit = LeaveAdjustment::where('staff_id', $staffId)
                ->where('leave_type_id', $mapping->leave_type_id)
                ->sum('credit');

            $debit = LeaveAdjustment::where('staff_id', $staffId)
                ->where('leave_type_id', $mapping->leave_type_id)
                ->sum('debit');

            // Balance = Default (from Mapping) + Manual Credits - Manual Debits
            $mapping->current_balance = $mapping->accrual_value + $credit - $debit;
        }

        return response()->json($mappings);
    }

    /**
     * API: Store Adjustments (Handles multiple rows from the grid)
     */
    public function apiStore(Request $request)
    {
        $request->validate([
            'staff_id' => 'required',
            'leave_type_id' => 'required|array',
            'leave_type_id.*' => 'required',
            'credit.*' => 'nullable|integer|min:0',
            'debit.*' => 'nullable|integer|min:0',
            'year' => 'required|integer',
            'remarks' => 'nullable|string',
        ]);

        $created = [];

        foreach ($request->leave_type_id as $index => $leaveTypeId) {
            $credit = $request->credit[$index] ?? 0;
            $debit  = $request->debit[$index] ?? 0;

            if ($credit == 0 && $debit == 0) continue;

            $adjustment = LeaveAdjustment::create([
                'id' => (string) Str::uuid(),
                'staff_id' => $request->staff_id,
                'leave_type_id' => $leaveTypeId,
                'credit' => $credit,
                'debit' => $debit,
                'year' => $request->year,
                'remarks' => $request->remarks,
            ]);
            
            $created[] = $adjustment;
        }

        return response()->json([
            'status' => 'success',
            'message' => count($created) . ' adjustments processed.',
            'data' => $created
        ]);
    }

    /**
     * API: Single Adjustment Detail
     */
    public function apiShow($id)
    {
        $adjustment = LeaveAdjustment::with(['staff', 'leaveType'])->findOrFail($id);
        return response()->json(['status' => 'success', 'data' => $adjustment]);
    }

}