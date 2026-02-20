<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Department;
use App\Helpers\ApiResponse;



class DesignationController extends Controller
{
    public function index()
    {
        $designations = Designation::with('department')
            ->orderBy('designation_name')
            ->get();

        return view('admin.masters.designation.index', compact('designations'));
    }


    public function create()
    {
        $departments = Department::where('status', 1)->get();
        return view('masters.designation.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'designation_code' => 'required|max:20|unique:designation_master',
            'designation_name' => 'required|max:100',
            'status' => 'required'
        ]);


        $status = $request->status == 'Active' ? 1 : 0;

        $code = strtoupper(substr($request->designation_name, 0, 3));

        Designation::create([
            'designation_code' => $request->designation_code,
            'designation_name' => $request->designation_name,
            'department_id' => $request->department_id,
            'description' => $request->description,
            'status' => $status,
            'created_by' => 1
        ]);

        return redirect()->route('admin.designation.index')
            ->with('success', 'Designation created successfully');
    }


    public function edit($id)
    {
        $designation = Designation::findOrFail($id);

        $departments = Department::where('status', 1)
            ->orWhere('id', $designation->department_id)
            ->get();

        return view('masters.designation.edit', compact('designation', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'designation_code' => 'required|max:20|unique:designation_master,designation_code',
                'designation_name' => 'required|max:100|unique:designation_master,designation_name',
                'status' => 'required'
            ],
            [
                'designation_code.required' => 'Designation code is required.',
                'designation_code.unique' => 'Designation code already exists.',
                'designation_name.required' => 'Designation name is required.',
                'designation_name.unique' => 'Designation already exists.',
                'status.required' => 'Please select status.'
            ]
        );


        $designation = Designation::findOrFail($id);

        $status = $request->status == 'Active' ? 1 : 0;

        $request->validate(
            [
                'designation_code' => "required|max:20|unique:designation_master,designation_code,$id",
                'designation_name' => "required|max:100|unique:designation_master,designation_name,$id",
                'status' => 'required'
            ],
            [
                'designation_code.required' => 'Designation code is required.',
                'designation_code.unique' => 'Designation code already exists.',
                'designation_name.required' => 'Designation name is required.',
                'designation_name.unique' => 'Designation already exists.',
                'status.required' => 'Please select status.'
            ]
        );



        return redirect()->route('admin.designation.index')
            ->with('success', 'Designation updated successfully');
    }

    public function destroy($id)
    {
        $designation = Designation::findOrFail($id);
        $designation->delete();

        return redirect()->route('admin.designation.index')
            ->with('success', 'Designation deleted successfully');
    }

    public function trash()
    {
        $designations = Designation::onlyTrashed()
            ->with('department')
            ->orderBy('designation_name')
            ->get();

        return view('masters.designation.trash', compact('designations'));
    }


    public function restore($id)
    {
        Designation::withTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.designation.trash')
            ->with('success', 'Designation restored');
    }

    public function forceDelete($id)
    {
        Designation::withTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('admin.designation.trash')
            ->with('success', 'Designation removed permanently');
    }

    //API

    public function apiIndex(Request $request)
    {
        $query = Designation::with('department');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $data = $query->orderBy('designation_name')->get();

        return ApiResponse::success($data, 'Designations fetched');
    }


    public function apiStore(Request $request)
    {
        $request->validate([
            'designation_code' => 'required|max:20|unique:designation_master,designation_code',
            'designation_name' => 'required|max:100',
            'department_id' => 'required|exists:department_master,id',
            'status' => 'required'
        ]);

        $data = Designation::create([
            'id' => Str::uuid(),
            'designation_code' => strtoupper($request->designation_code),
            'designation_name' => $request->designation_name,
            'department_id' => $request->department_id,
            'description' => $request->description,
            'status' => $request->status,
            'created_by' => 1
        ]);

        return ApiResponse::success($data, 'Designation created successfully');
    }


    public function apiUpdate(Request $request, $id)
    {
        $data = Designation::findOrFail($id);

        $request->validate([
            'designation_code' => 'required|max:20|unique:designation_master,designation_code,' . $id . ',id',
            'designation_name' => 'required|max:100',
            'department_id' => 'required|exists:department_master,id',
            'status' => 'required'
        ]);

        $data->update([
            'designation_code' => strtoupper($request->designation_code),
            'designation_name' => $request->designation_name,
            'department_id' => $request->department_id,
            'description' => $request->description,
            'status' => $request->status,
            'updated_by' => 1
        ]);

        return ApiResponse::success($data, 'Designation updated successfully');
    }


    public function apiDelete($id)
    {
        $data = Designation::findOrFail($id);
        $data->delete();

        return ApiResponse::success(null, 'Designation deleted');
    }

    public function apiDeleted()
    {
        $data = Designation::onlyTrashed()->get();
        return ApiResponse::success($data, 'Deleted designations fetched');
    }

    public function apiRestore($id)
    {
        $data = Designation::withTrashed()->findOrFail($id);
        $data->restore();

        return ApiResponse::success($data, 'Designation restored');
    }

    public function apiForceDelete($id)
    {
        $data = Designation::withTrashed()->findOrFail($id);
        $data->forceDelete();

        return ApiResponse::success(null, 'Designation permanently deleted');
    }


}

