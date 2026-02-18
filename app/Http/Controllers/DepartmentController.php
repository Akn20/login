<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use App\Helpers\ApiResponse;
use Illuminate\Support\Str;



class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::orderBy('department_name')->paginate(10);
        return view('admin.masters.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.masters.departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_name' => [
                'required',
                'max:100',
                Rule::unique('department_master', 'department_name')->whereNull('deleted_at'),
            ],
            'department_code' => [
                'required',
                'max:20',
                Rule::unique('department_master', 'department_code')->whereNull('deleted_at'),
            ],
            'description' => ['nullable'],
            'status' => ['required', Rule::in(['1', '0'])], // from select
        ]);
        Department::create([
            'department_name' => $request->department_name,
            'department_code' => strtoupper($request->department_code),
            'description' => $request->description,
            'status' => (bool) $request->status,
            'created_by' => auth()->id() ?? null,
        ]);

        return redirect()->route('admin.departments.index')->with('success', 'Department added.');
    }

    public function edit(string $id)
    {
        $department = Department::findOrFail($id);
        return view('masters.departments.edit', compact('department'));
    }


    public function update(Request $request, string $id)
    {
        $department = Department::findOrFail($id);
        $request->validate([
            'department_name' => [
                'required',
                'max:100',
                Rule::unique('department_master', 'department_name')
                    ->ignore($department->id, 'id')
                    ->whereNull('deleted_at'),
            ],
            'department_code' => [
                'required',
                'max:20',
                Rule::unique('department_master', 'department_code')
                    ->ignore($department->id, 'id')
                    ->whereNull('deleted_at'),
            ],
            'description' => ['nullable'],
            'status' => ['required', Rule::in(['1', '0'])],
        ]);

        $department->update([
            'department_name' => $request->department_name,
            'department_code' => strtoupper($request->department_code),
            'description' => $request->description,
            'status' => (bool) $request->status,
            'updated_by' => auth()->id() ?? null,
        ]);

        return redirect()->route('admin.departments.index')->with('success', 'Department updated.');
    }

    public function destroy(string $id)
    {
        $department = Department::findOrFail($id);

        if (Schema::hasTable('staff') && \DB::table('staff')->where('department_id', $id)->exists()) {
            return back()->with('error', 'Cannot delete: department is assigned to staff.');
        }

        $department->delete();
        return back()->with('success', 'Department deleted.');
    }

    public function deletedHistory()
    {
        $departments = Department::onlyTrashed()
            ->orderBy('department_name')
            ->paginate(10);

        return view('admin.masters.departments.deleted', compact('departments'));
    }

    public function restore(string $id)
    {
        $department = Department::onlyTrashed()->findOrFail($id);
        $department->restore();

        return redirect()->route('admin.departments.deleted')
            ->with('success', 'Department restored successfully.');
    }

    public function forceDelete(string $id)
    {
        $department = Department::onlyTrashed()->findOrFail($id);
        $department->forceDelete();

        return redirect()->route('admin.departments.deleted')
            ->with('success', 'Department permanently deleted.');
    }

    //API

    public function apiIndex(Request $request)
    {
        $query = Department::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $data = $query->orderBy('department_name')->get();

        return ApiResponse::success($data, 'Departments fetched');
    }



    public function apiStore(Request $request)
    {
        $request->validate([
            'department_name' => 'required|max:100',
            'department_code' => 'required|max:20',
            'status' => 'required'
        ]);

        $data = Department::create([
            'id' => Str::uuid(),
            'department_name' => $request->department_name,
            'department_code' => strtoupper($request->department_code),
            'description' => $request->description,
            'status' => $request->status,
            'created_by' => 1
        ]);

        return ApiResponse::success($data, 'Department created successfully');
    }


    public function apiUpdate(Request $request, $id)
    {
        $data = Department::findOrFail($id);

        $data->update([
            'department_name' => $request->department_name,
            'department_code' => strtoupper($request->department_code),
            'description' => $request->description,
            'status' => $request->status,
            'updated_by' => 1
        ]);

        return ApiResponse::success($data, 'Department updated successfully');
    }


    public function apiDelete($id)
    {
        $data = Department::findOrFail($id);
        $data->delete();

        return ApiResponse::success(null, 'Department deleted');
    }

    public function apiDeleted()
    {
        $data = Department::onlyTrashed()->get();
        return ApiResponse::success($data, 'Deleted departments fetched');
    }

    public function apiRestore($id)
    {
        $data = Department::withTrashed()->findOrFail($id);
        $data->restore();

        return ApiResponse::success($data, 'Department restored');
    }

    public function apiForceDelete($id)
    {
        $data = Department::withTrashed()->findOrFail($id);
        $data->forceDelete();

        return ApiResponse::success(null, 'Department permanently deleted');
    }


}
