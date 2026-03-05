<?php

namespace App\Http\Controllers\LeaveManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveType;

class LeaveTypeController extends Controller
{
    /**
     * Display Leave Types
     */
    public function index(Request $request)
    {
        $query = LeaveType::query();

        if ($request->filled('search')) {
            $query->where('display_name', 'like', '%' . $request->search . '%');
        }

        $leaveTypes = $query->latest()->paginate(10);
        $leaveTypes->appends($request->all());

        return view(
            'admin.Leave_Management.leave_type.index',
            compact('leaveTypes')
        );
    }

    /**
     * Show Create Form
     */
    public function create()
    {
        return view('admin.Leave_Management.leave_type.form');
    }

    /**
     * Store Leave Type
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
        [
            // TC_LTM_001 & TC_LTM_002
            'display_name'        => 'required|string|max:255|unique:leave_types,display_name',
            'description'         => 'nullable|string|max:1000',

            // TC_LTM_003
            'allow_half_day'      => 'required|in:0,1',
            'min_leave_unit'      => 'required|in:0.5,1',

            // TC_LTM_004
            'sandwich_enabled'    => 'required|in:0,1',
            'sandwich_applies_on' => 'nullable|required_if:sandwich_enabled,1|in:Weekend,Holiday,Both',

            // TC_LTM_005
            'approval_required'   => 'required|in:0,1',
            'approval_level'      => 'required_if:approval_required,1|in:Single,Multi',

            // TC_LTM_006
            'attendance_code'     => 'nullable|string|max:50',

            // Duration
            'max_continuous_days' => 'nullable|integer|min:1|max:365',

            // Backdate
            'allow_backdate'      => 'required|in:0,1',
            'max_backdate_days'   => 'nullable|required_if:allow_backdate,1|integer|min:0|max:365',

            // Calendar
            'count_weekends'      => 'required|in:0,1',
            'count_holidays'      => 'required|in:0,1',

            // TC_LTM_006
'attendance_code' => 'nullable|string|max:10|unique:leave_types,attendance_code',
        ],
        [
            'display_name.unique' => 'Leave Type already exists.',
            'sandwich_applies_on.required_if' =>
                'Select where sandwich rule applies when enabled.',
            'approval_level.required_if' =>
                'Approval level must be selected when approval is required.',
            'max_backdate_days.required_if' =>
                'Enter max backdate days when backdate is allowed.',
        ]);

        // ✅ Half-Day strict validation (TC_LTM_003)
        if ($request->allow_half_day == 1 && $request->min_leave_unit != 0.5) {
            return back()
                ->withErrors([
                    'min_leave_unit' =>
                        'Minimum Leave Unit must be 0.5 when Half Day is enabled.'
                ])
                ->withInput();
        }

        LeaveType::create($validated);

        return redirect()
            ->route('admin.leave-type.index')
            ->with('success', 'Leave Type created successfully!');
    }

    /**
     * Edit Form
     */
    public function edit($id)
    {
        $leaveType = LeaveType::findOrFail($id);

        return view(
            'admin.Leave_Management.leave_type.form',
            compact('leaveType')
        );
    }

    /**
     * Update Leave Type
     */
    public function update(Request $request, $id)
    {
        $leaveType = LeaveType::findOrFail($id);

        $validated = $request->validate([
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'allow_half_day' => 'required|boolean',
            'min_leave_unit' => 'required|numeric',
            'max_continuous_days' => 'nullable|integer',
            'count_weekends' => 'required|boolean',
            'count_holidays' => 'required|boolean',
            'sandwich_enabled' => 'required|boolean',
            'sandwich_applies_on' => 'nullable|string',
            'approval_required' => 'required|boolean',
            'approval_level' => 'required|string',
            'allow_backdate' => 'required|boolean',
            'max_backdate_days' => 'nullable|integer',
            'attendance_code' => 'nullable|string|max:50',
        ]);

        // ✅ Apply same Half-Day logic in update
        if ($request->allow_half_day == 1 && $request->min_leave_unit != 0.5) {
            return back()
                ->withErrors([
                    'min_leave_unit' =>
                        'Minimum Leave Unit must be 0.5 when Half Day is enabled.'
                ])
                ->withInput();
        }

        $leaveType->update($validated);

        return redirect()
            ->route('admin.leave-type.index')
            ->with('success', 'Leave Type updated successfully!');
    }

    /**
     * Soft Delete
     */
    public function destroy($id)
    {
        $leaveType = LeaveType::findOrFail($id);
        $leaveType->delete();

        return redirect()
            ->route('admin.leave-type.index')
            ->with('success', 'Leave Type moved to trash successfully!');
    }

    /**
     * Deleted Leave Types
     */
    public function deleted()
    {
        $leaveTypes = LeaveType::onlyTrashed()
            ->latest()
            ->paginate(10);

        return view(
            'admin.Leave_Management.leave_type.deleted',
            compact('leaveTypes')
        );
    }

    /**
     * Restore
     */
    public function restore($id)
    {
        $leaveType = LeaveType::onlyTrashed()->findOrFail($id);
        $leaveType->restore();

        return redirect()
            ->route('admin.leave-type.deleted')
            ->with('success', 'Leave Type restored successfully!');
    }

    /**
     * Permanent Delete
     */
    public function forceDelete($id)
    {
        $leaveType = LeaveType::onlyTrashed()->findOrFail($id);
        $leaveType->forceDelete();

        return redirect()
            ->route('admin.leave-type.deleted')
            ->with('success', 'Leave Type permanently deleted!');
    }



    /**
     * API Endpoint for Leave Types
     */
public function apiIndex()
 {
     $leaveTypes = \App\Models\LeaveType::select('id','display_name as name')->get();

     return response()->json([
         'status' => true,
         'data' => $leaveTypes   ]);
 }
}