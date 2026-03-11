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
        $mappings = LeaveMapping::with('leaveType')->latest()->paginate(10);
        $designationMap = Designation::pluck('designation_name', 'id');

        return view('admin.Leave_Management.leave_mappings.index', compact('mappings', 'designationMap'));
    }

    public function create()
    {
        $leaveTypes   = \App\Models\LeaveType::all();
        $designations = \App\Models\Designation::orderBy('designation_name', 'asc')->get();

        return view('admin.Leave_Management.leave_mappings.create', compact('leaveTypes', 'designations'));
    }

    // -------------------------------------------------------
    // Helper: check for a duplicate mapping
    // $excludeId — pass the current record's ID when updating
    // -------------------------------------------------------
    private function duplicateExists(Request $request, $excludeId = null): bool
    {
        // employee_status is a multi-select array
        $inputStatus = is_array($request->employee_status)
            ? $request->employee_status
            : [$request->employee_status];
        sort($inputStatus);

        // designations is a single UUID from a dropdown
        $inputDesignation    = $request->designations;
        $inputGender         = $request->gender;
        $inputEmploymentType = $request->employment_type;

        $query = DB::table('leave_mappings')
            ->where('leave_type_id', $request->leave_type_id)
            ->where('gender', $inputGender)
            ->where('employment_type', $inputEmploymentType)
            ->whereNull('deleted_at');

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $existingMappings = $query->get()->filter(function ($mapping) use ($inputDesignation) {
            // designations is stored as a JSON array e.g. ["uuid-1"]
            $db = json_decode($mapping->designations, true);
            if (is_array($db)) {
                return in_array($inputDesignation, $db);
            }
            return $mapping->designations === $inputDesignation;
        });

        foreach ($existingMappings as $mapping) {
            $dbStatus = json_decode($mapping->employee_status, true) ?? [];
            sort($dbStatus);

            if ($dbStatus === $inputStatus) {
                return true;
            }
        }

        return false;
    }

    public function store(Request $request)
    {
        if ($this->duplicateExists($request)) {
            return redirect()->back()
                ->withInput()
                ->with('error_message', 'A mapping for this Leave Type, Employee Status, Designation, Gender, and Employment Type combination already exists!');
        }

        // Sync checkboxes to boolean/string values
        $request->merge([
            'status'                => $request->has('status') ? 'active' : 'inactive',
            'carry_forward_allowed' => $request->has('carry_forward_allowed'),
            'encashment_allowed'    => $request->has('encashment_allowed'),
        ]);

        $data = $request->validate([
            'leave_type_id'             => 'required|uuid',
            'priority'                  => 'required|integer',
            'employee_status'           => 'required|array',
            'designations'              => 'required',
            'gender'                    => 'required|in:Male,Female,All',
            'employment_type'           => 'required|in:Full-time,Part-time,All',
            'accrual_frequency'         => 'required|in:Monthly,Yearly,Event Based',
            'accrual_value'             => 'required|integer',
            'leave_nature'              => 'required|in:Paid,Unpaid',
            'status'                    => 'required|in:active,inactive',
            'encashment_allowed'        => 'boolean',
            'encashment_trigger'        => 'nullable|string|in:Year-end,Exit,Specific Date',
            'carry_forward_allowed'     => 'boolean',
            'carry_forward_limit'       => 'nullable|integer',
            'carry_forward_expiry_days' => 'nullable|integer',
            'min_leave_per_application' => 'required|integer|min:1',
            'max_leave_per_application' => 'nullable|integer|gte:min_leave_per_application',
        ], [
            'max_leave_per_application.gte' => 'The maximum leave must be greater than or equal to the minimum leave per application.',
        ]);

        // Wrap single designation UUID in an array before saving as JSON
        if (isset($data['designations']) && !is_array($data['designations'])) {
            $data['designations'] = [$data['designations']];
        }

        LeaveMapping::create($data);

        return redirect()->route('admin.leave-mappings.index')->with('success', 'Mapping created successfully!');
    }

    public function edit($id)
    {
        $mapping      = LeaveMapping::findOrFail($id);
        $leaveTypes   = LeaveType::all();
        $designations = Designation::orderBy('designation_name', 'asc')->get();

        return view('admin.Leave_Management.leave_mappings.edit', compact('mapping', 'leaveTypes', 'designations'));
    }

    public function show($id)
    {
        $mapping        = LeaveMapping::with('leaveType')->findOrFail($id);
        $designationMap = Designation::pluck('designation_name', 'id');

        return view('admin.Leave_Management.leave_mappings.show', compact('mapping', 'designationMap'));
    }

    public function update(Request $request, $id)
    {
        $mapping = \App\Models\LeaveMapping::findOrFail($id);

        // Duplicate check — excludes the current record from comparison
        if ($this->duplicateExists($request, $id)) {
            return redirect()->back()
                ->withInput()
                ->with('error_message', 'A mapping for this Leave Type, Employee Status, Designation, Gender, and Employment Type combination already exists!');
        }

        $request->merge([
            'status'                => $request->has('status') ? 'active' : 'inactive',
            'carry_forward_allowed' => $request->has('carry_forward_allowed'),
            'encashment_allowed'    => $request->has('encashment_allowed'),
        ]);

        $data = $request->validate([
            'leave_type_id'             => 'required|uuid',
            'priority'                  => 'required|integer',
            'employee_status'           => 'required|array',
            'designations'              => 'required',
            'gender'                    => 'required|in:Male,Female,All',
            'employment_type'           => 'required|in:Full-time,Part-time,All',
            'accrual_frequency'         => 'required|in:Monthly,Yearly,Event Based',
            'accrual_value'             => 'required|integer',
            'leave_nature'              => 'required|in:Paid,Unpaid',
            'status'                    => 'required|in:active,inactive',
            'encashment_allowed'        => 'boolean',
            'encashment_trigger'        => 'nullable|string',
            'carry_forward_allowed'     => 'boolean',
            'carry_forward_limit'       => 'nullable|integer',
            'carry_forward_expiry_days' => 'nullable|integer',
            'min_leave_per_application' => 'required|integer|min:1',
            'max_leave_per_application' => 'nullable|integer|gte:min_leave_per_application',
        ], [
            'max_leave_per_application.gte' => 'The maximum leave must be greater than or equal to the minimum leave per application.',
        ]);

        if (isset($data['designations']) && !is_array($data['designations'])) {
            $data['designations'] = [$data['designations']];
        }

        $mapping->update($data);

        return redirect()->route('admin.leave-mappings.index')->with('success', 'Mapping updated successfully!');
    }

    public function destroy($id)
    {
        LeaveMapping::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Moved to trash');
    }

    public function deleted()
    {
        $mappings = LeaveMapping::onlyTrashed()->with('leaveType')->get();
        return view('admin.Leave_Management.leave_mappings.deleted', compact('mappings'));
    }

    public function forceDelete($id)
    {
        LeaveMapping::withTrashed()->findOrFail($id)->forceDelete();
        return redirect()->back()->with('success', 'Mapping permanently deleted');
    }

    public function restore($id)
    {
        LeaveMapping::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.leave-mappings.index')->with('success', 'Restored');
    }


    // ================== API METHODS ==================

    public function apiIndex()
    {
        $mappings = LeaveMapping::with('leaveType')->get();

        return response()->json([
            'status' => true,
            'data'   => $mappings,
        ]);
    }

    public function apiShow($id)
    {
        $mapping = LeaveMapping::with('leaveType')->find($id);

        if (!$mapping) {
            return response()->json(['status' => false, 'message' => 'Mapping not found'], 404);
        }

        return response()->json(['status' => true, 'data' => $mapping]);
    }

    public function apiStore(Request $request)
    {
        $data = $request->validate([
            'leave_type_id'             => 'required|uuid',
            'priority'                  => 'required|integer',
            'employee_status'           => 'required|array',
            'designations'              => 'required',
            'gender'                    => 'required|in:Male,Female,All',
            'employment_type'           => 'required|in:Full-time,Part-time,All',
            'accrual_frequency'         => 'required|in:Monthly,Yearly,Event Based',
            'accrual_value'             => 'required|integer',
            'leave_nature'              => 'required|in:Paid,Unpaid',
            'carry_forward_allowed'     => 'nullable|boolean',
            'carry_forward_limit'       => 'nullable|integer',
            'carry_forward_expiry_days' => 'nullable|integer',
            'min_leave_per_application' => 'nullable|integer',
            'max_leave_per_application' => 'nullable|integer',
            'status'                    => 'required|in:active,inactive',
        ]);

        $mapping = LeaveMapping::create($data);

        return response()->json([
            'status'  => true,
            'message' => 'Mapping created successfully',
            'data'    => $mapping,
        ]);
    }

    public function apiUpdate(Request $request, $id)
    {
        $mapping = LeaveMapping::find($id);

        if (!$mapping) {
            return response()->json(['status' => false, 'message' => 'Mapping not found'], 404);
        }

        $data = $request->validate([
            'leave_type_id'             => 'sometimes|uuid',
            'priority'                  => 'sometimes|integer',
            'employee_status'           => 'sometimes|array',
            'designations'              => 'sometimes',
            'gender'                    => 'sometimes|in:Male,Female,All',
            'employment_type'           => 'sometimes|in:Full-time,Part-time,All',
            'accrual_frequency'         => 'sometimes|in:Monthly,Yearly,Event Based',
            'accrual_value'             => 'sometimes|integer',
            'leave_nature'              => 'sometimes|in:Paid,Unpaid',
            'carry_forward_allowed'     => 'nullable|boolean',
            'carry_forward_limit'       => 'nullable|integer',
            'carry_forward_expiry_days' => 'nullable|integer',
            'min_leave_per_application' => 'nullable|integer',
            'max_leave_per_application' => 'nullable|integer',
            'status'                    => 'sometimes|in:active,inactive',
        ]);

        $mapping->update($data);

        return response()->json([
            'status'  => true,
            'message' => 'Mapping updated successfully',
            'data'    => $mapping,
        ]);
    }

    public function apiDestroy($id)
    {
        $mapping = LeaveMapping::find($id);

        if (!$mapping) {
            return response()->json(['status' => false, 'message' => 'Mapping not found'], 404);
        }

        $mapping->delete();

        return response()->json(['status' => true, 'message' => 'Mapping deleted successfully']);
    }

    public function apiDeleted()
    {
        $mappings = LeaveMapping::onlyTrashed()->with('leaveType')->get();

        return response()->json(['status' => true, 'data' => $mappings]);
    }

    public function apiRestore($id)
    {
        $mapping = LeaveMapping::onlyTrashed()->find($id);

        if (!$mapping) {
            return response()->json(['status' => false, 'message' => 'Mapping not found'], 404);
        }

        $mapping->restore();

        return response()->json(['status' => true, 'message' => 'Mapping restored successfully']);
    }

    public function apiForceDelete($id)
    {
        $mapping = LeaveMapping::onlyTrashed()->find($id);

        if (!$mapping) {
            return response()->json(['status' => false, 'message' => 'Mapping not found'], 404);
        }

        $mapping->forceDelete();

        return response()->json(['status' => true, 'message' => 'Mapping permanently deleted']);
    }
}