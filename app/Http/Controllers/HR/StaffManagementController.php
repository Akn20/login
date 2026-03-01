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

        if (request()->wantsJson()) {
            $staffManagements = Staff::latest()->get();

            return response()->json($staffManagements);
        }

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
        'department' => 'required',
        'designation' => 'required',
        'joining_date' => 'required|date',
       // 'joining_date' => 'required',//changed
        'status' => 'required',
    ]);

    Staff::create([
        'employee_id' => $request->employee_id,
        'name' => $request->name,
        'department' => $request->department,
        'designation' => $request->designation,
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
        'employee_id' => 'required|unique:staff,employee_id,' . $id,
        'name' => 'required',
        'department' => 'required',
        'designation' => 'required',
        'joining_date' => 'required|date',
        'status' => 'required',
    ]);

    $staff->update([
        'employee_id' => $request->employee_id,
        'name' => $request->name,
        'department' => $request->department,
        'designation' => $request->designation,
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

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Staff deleted successfully.',
            ]);
        }

        return redirect()
            ->route('hr.staff-management.index')
            ->with('success', 'Staff deleted successfully.');
    }

    public function deleted()
    {
        $staffs = Staff::onlyTrashed()->latest()->paginate(10);

        if (request()->wantsJson()) {
            $staffs = Staff::onlyTrashed()->latest()->get();

            return response()->json([
                'success' => true,
                'data' => $staffs,
            ]);
        }

        return view('hr.staff_management.deleted', compact('staffs'));
    }

    public function restore($id)
    {
        $staff = Staff::onlyTrashed()->findOrFail($id);
        $staff->restore();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Staff restored successfully.',
                'data' => $staff,
            ]);
        }

        return redirect()
            ->route('hr.staff-management.deleted')
            ->with('success', 'Staff restored successfully.');
    }

    public function forceDelete($id)
    {
        $staff = Staff::onlyTrashed()->findOrFail($id);
        $staff->forceDelete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Staff permanently deleted.',
            ]);
        }

        return redirect()
            ->route('hr.staff-management.deleted')
            ->with('success', 'Staff permanently deleted.');
    }
public function show($id)
{
    $staff = Staff::findOrFail($id);

    return view('hr.staff_management.show', compact('staff'));
}
    // App API Endpoints
    public function apiIndex()
    {
        $staff = Staff::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $staff,
        ]);
    }

    public function apiStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'joining_date' => 'nullable|date',  // default DOJ for app
        ]);

        $staff = Staff::create([
            'name' => $data['name'],
            'status' => $data['status'],
            'joining_date' => $data['joining_date'] ?? now(), // default DOJ for app
            'role' => $data['role'] ?? null,
            'department' => $data['department'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Staff added successfully.',
            'data' => $staff,
        ]);
    }

    public function apiUpdate(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'role' => 'sometimes|nullable|string|max:255',
            'department' => 'sometimes|nullable|string|max:255',
            'status' => 'sometimes|required|in:active,inactive',
            'joining_date' => 'sometimes|nullable|date',
        ]);

        $staff->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Staff updated successfully.',
            'data' => $staff,
        ]);
    }

    public function apiDestroy($id)
    {
        $staff = Staff::findOrFail($id);
        $staff->delete();

        return response()->json([
            'success' => true,
            'message' => 'Staff deleted successfully.',
        ]);
    }

    public function apiDeleted()
    {
        $staffs = Staff::onlyTrashed()->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $staffs,
        ]);
    }

    public function apiRestore($id)
    {
        $staff = Staff::onlyTrashed()->findOrFail($id);
        $staff->restore();

        return response()->json([
            'success' => true,
            'message' => 'Staff restored successfully.',
            'data' => $staff,
        ]);
    }

    public function apiForceDelete($id)
    {
        $staff = Staff::onlyTrashed()->findOrFail($id);
        $staff->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'Staff permanently deleted.',
        ]);
    }
}
