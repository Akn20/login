<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Roles;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StaffManagementController extends Controller
{
    private function generateEmployeeId()
    {
        $lastId = Staff::withTrashed()->max('id');
        $nextNumber = $lastId ? $lastId + 1 : 1;

        return 'EMP-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    public function index()
    {
        $staffManagement = Staff::with([
            'role',
            'user',
            'department',
            'designation',
        ])->latest()->paginate(10);

        if (request()->wantsJson()) {
            return response()->json(
                Staff::with(['role', 'user', 'department', 'designation'])->latest()->get()
            );
        }

        return view('hr.staff_management.index', compact('staffManagement'));
    }

    // public function create()
    // {
    //     $staffManagement = null;
    //     $roles = Roles::where('status', 'active')->orderBy('name', 'asc')->get();

    //     return view('hr.staff_management.create', compact('staffManagement', 'roles'));
    // }

    public function create()
    {
        $staffManagement = null;

        $roles = Roles::where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();

        $departments = Department::where('status', 1)
            ->orderBy('department_name', 'asc')
            ->get();

        $designations = Designation::where('status', 1)
            ->orderBy('designation_name', 'asc')
            ->get();

        return view('hr.staff_management.create', compact(
            'staffManagement',
            'roles',
            'departments',
            'designations'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
            // 'department' => 'required|string|max:255',
            // 'designation' => 'required|string|max:255',

            'department_id' => 'required|exists:department_master,id',
            'designation_id' => 'required|exists:designation_master,id',
            'joining_date' => 'required|date|before_or_equal:today',
            'status' => 'required|in:Active,Inactive',
            'mobile' => 'required|digits:10|unique:users,mobile',
            'email' => 'nullable|email|unique:users,email',
            'basic_salary' => 'nullable|numeric|min:0',
            'hra' => 'nullable|numeric|min:0',
            'allowance' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // 1. Create User first (Matches your User Migration)
                $user = User::create([
                    'id' => (string) Str::uuid(),
                    'name' => $request->name,
                    'mobile' => $request->mobile,
                    'email' => $request->email,
                    'role_id' => $request->role_id,
                    'status' => strtolower($request->status), // users table uses lowercase enum
                    'mpin' => null,

                ]);
                // uplpoad document
                $documentPath = null;

                if ($request->hasFile('document')) {
                    $documentPath = $request->file('document')->store('staff_documents', 'public');
                }

                // 2. Create Staff linked to the User
                Staff::create([
                    'user_id' => $user->id,
                    'employee_id' => $this->generateEmployeeId(),
                    'name' => $request->name,
                    'role_id' => $request->role_id,
                    // 'department' => $request->department,
                    // 'designation' => $request->designation,
                    'department_id' => $request->department_id,
                    'designation_id' => $request->designation_id,
                    'joining_date' => $request->joining_date,
                    'status' => $request->status,
                    'document_path' => $documentPath,
                    'basic_salary' => $request->basic_salary,
                    'hra' => $request->hra,
                    'allowance' => $request->allowance,
                ]);
            });

            return redirect()->route('hr.staff-management.index')
                ->with('success', 'Staff and User account created successfully.');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating staff: ' . $e->getMessage());
        }
    }

    // public function edit($id)
    // {
    //     $staffManagement = Staff::findOrFail($id);
    //     $roles = Roles::where('status', 'active')->orderBy('name', 'asc')->get();

    //     return view('hr.staff_management.edit', compact('staffManagement', 'roles'));
    // }
    public function edit($id)
    {
        $staffManagement = Staff::findOrFail($id);

        $roles = Roles::where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();

        $departments = Department::where('status', 1)
            ->orderBy('department_name', 'asc')
            ->get();

        $designations = Designation::where('status', 1)
            ->orderBy('designation_name', 'asc')
            ->get();

        return view('hr.staff_management.edit', compact(
            'staffManagement',
            'roles',
            'departments',
            'designations'
        ));
    }

    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
            // 'department' => 'required|string|max:255',
            // 'designation' => 'required|string|max:255',
            'department_id' => 'required|exists:department_master,id',
            'designation_id' => 'required|exists:designation_master,id',
            'joining_date' => 'required|date|before_or_equal:today',
            'status' => 'required|in:Active,Inactive',
            // 'mobile' => 'required|digits:10|unique:users,mobile,' . $staff->user_id,
            // 'email' => 'nullable|email|unique:users,email,' . $staff->user_id,
            'mobile' => 'required|digits:10|unique:users,mobile,' . $staff->user_id . ',id',
            'email' => 'nullable|email|unique:users,email,' . $staff->user_id . ',id',
            'basic_salary' => 'nullable|numeric|min:0',
            'hra' => 'nullable|numeric|min:0',
            'allowance' => 'nullable|numeric|min:0',

        ]);

        try {
            DB::transaction(function () use ($request, $staff) {

                $documentPath = $staff->document_path;

                if ($request->hasFile('document')) {
                    $documentPath = $request->file('document')->store('staff_documents', 'public');
                }
                // Update Staff
                $staff->update([
                    'name' => $request->name,
                    'role_id' => $request->role_id,

                    'joining_date' => $request->joining_date,
                    'status' => $request->status,
                    'department_id' => $request->department_id,
                    'designation_id' => $request->designation_id,
                    'document_path' => $documentPath,
                    'basic_salary' => $request->basic_salary,
                    'hra' => $request->hra,
                    'allowance' => $request->allowance,
                ]);

                // Update linked User if exists
                if ($staff->user_id) {
                    User::where('id', $staff->user_id)->update([
                        'name' => $request->name,
                        'mobile' => $request->mobile,
                        'email' => $request->email,
                        'role_id' => $request->role_id,
                        'status' => strtolower($request->status),
                    ]);
                }
            });

            return redirect()->route('hr.staff-management.index')
                ->with('success', 'Staff updated successfully.');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);

        // Use transaction to ensure user is also soft-deleted if needed
        DB::transaction(function () use ($staff) {
            if ($staff->user_id) {
                User::where('id', $staff->user_id)->delete();
            }
            $staff->delete();
        });

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Staff and linked User deleted.']);
        }

        return redirect()->route('hr.staff-management.index')->with('success', 'Staff deleted successfully.');
    }

    // --- Soft Delete Management Methods ---

    public function deleted()
    {
        $staffManagement = Staff::with([
            'department',
            'designation',
            'role',
        ])
            ->onlyTrashed()
            ->latest()
            ->paginate(10);

        return view('hr.staff_management.deleted', compact('staffManagement'));
    }

    public function restore($id)
    {
        $staff = Staff::onlyTrashed()->findOrFail($id);

        DB::transaction(function () use ($staff) {
            if ($staff->user_id) {
                User::withTrashed()->where('id', $staff->user_id)->restore();
            }
            $staff->restore();
        });

        return redirect()->route('hr.staff-management.deleted')->with('success', 'Staff restored successfully.');
    }

    public function forceDelete($id)
    {
        $staff = Staff::onlyTrashed()->findOrFail($id);

        DB::transaction(function () use ($staff) {
            if ($staff->user_id) {
                User::withTrashed()->where('id', $staff->user_id)->forceDelete();
            }
            $staff->forceDelete();
        });

        return redirect()->route('hr.staff-management.deleted')->with('success', 'Staff permanently deleted.');
    }

    public function show($id)
    {
        $staffManagement = Staff::with([
            'role',
            'user',
            'department',
            'designation',
        ])->findOrFail($id);

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
            'designation' => 'required|string|max:255',
            'joining_date' => 'nullable|date',  // default DOJ for app
        ]);

        $staff = Staff::create([
            'employee_id' => $this->generateEmployeeId(),
            'name' => $data['name'],
            'status' => $data['status'],
            'joining_date' => $data['joining_date'] ?? now(), // default DOJ for app
            'designation' => $data['designation'],
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
            'designation' => 'sometimes|required|string|max:255',
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
    public function apiDoctors()
    {
        $doctors = Staff::select('id', 'name')
            ->where('status', 'Active')
            ->get();

        return response()->json($doctors);
    }
      //added by sushan for api
 public function getSurgeons()
{
    $surgeons = Staff::whereHas('designation', function ($query) {
        $query->where('designation_name', 'Surgeon');
    })
    ->select('id','name')
    ->get();

    return response()->json([
        'success' => true,
        'data' => $surgeons
    ]);
}
//added by sushan for api
public function getAssistantDoctors()
{
    $assistantDoctors = Staff::whereHas('designation', function ($query) {
        $query->where('designation_name', 'Doctor');
    })
    ->select('id','name')
    ->get();

    return response()->json([
        'success' => true,
        'data' => $assistantDoctors
    ]);
}
//added by sushan for api
public function getAnesthetists()
{
    $anesthetists = Staff::whereHas('designation', function ($query) {
        $query->where('designation_name', 'Anesthetist');
    })
    ->select('id','name')
    ->get();

    return response()->json([
        'success' => true,
        'data' => $anesthetists
    ]);
}
}

 
