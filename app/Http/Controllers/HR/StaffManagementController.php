<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffManagementController extends Controller
{

    private function generateEmployeeId()
    {
        $last = Staff::orderBy('id', 'desc')->first();
        $nextNumber = $last ? ($last->id + 1) : 1;
    
        // Format as EMP-0001, EMP-0002, etc.
        return 'EMP-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
    public function index()
    {
        $staffManagement = Staff::latest()->paginate(10);

        if (request()->wantsJson()) {
            $staffManagement = Staff::latest()->get();

            return response()->json($staffManagement);
        }

        return view('hr.staff_management.index', compact('staffManagement'));
    }

   public function create()
{
    $staffManagement = null;   // important
    return view('hr.staff_management.create', compact('staffManagement'));
}

   public function store(Request $request)
{
    $request->validate([
       // 'employee_id' => 'required|unique:staff,employee_id',
        'name' => 'required',
        'department' => 'required|string|max:255',
        'designation' => 'required',
        'joining_date' => 'required|date',
       // 'joining_date' => 'required',//changed
        'status' => 'required',
        'role'=>'required',
        
    ]);
Staff::create([
    'employee_id' => $this->generateEmployeeId(),
    'name' => $request->name,
    'role' => $request->role,
    'department' => $request->department,
    'designation' => $request->designation,   //  ADD THIS
    'joining_date' => $request->joining_date,
    'status' => $request->status,
]);

    return redirect()->route('hr.staff-management.index')
        ->with('success', 'Staff added successfully.');
}

    public function edit($id)
    {
        $staffManagement = Staff::findOrFail($id);

        return view('hr.staff_management.edit', compact('staffManagement'));
    }

   public function update(Request $request, $id)
{
    $staff = Staff::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'role' => 'required',
            'department' => 'required|string|max:255',
            'joining_date' => 'required|date',
            'status' => 'required',
            'designation' => 'required',
            
        ]);

        $staff->update([
            'name' => $request->name,
            'role' => $request->role,
            'department' => $request->department,
            'joining_date' => $request->joining_date,
            'status' => $request->status,
            'designation' => $request->designation,
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
        $staffManagement = Staff::onlyTrashed()->latest()->paginate(10);

        if (request()->wantsJson()) {
            $staffs = Staff::onlyTrashed()->latest()->get();

            return response()->json([
                'success' => true,
                'data' => $staffs,
            ]);
        }

        return view('hr.staff_management.deleted', compact('staffManagement'));
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
    $staffManagement = Staff::findOrFail($id);

    return view('hr.staff_management.show', compact('staffManagement'));
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
            'employee_id' => $this->generateEmployeeId(),
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
