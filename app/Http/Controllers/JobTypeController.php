<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;
use Illuminate\Support\Str;

class JobTypeController extends Controller
{
    public function index()
    {
        $jobTypes = JobType::latest()->get();
        return view('admin.masters.job_type.index', compact('jobTypes'));
    }

    public function create()
    {
        return view('admin.masters.job_type.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'job_type_code' => 'required|max:50|unique:job_type_master,job_type_code',
                'job_type_name' => 'required|max:100|unique:job_type_master,job_type_name',
                'status' => 'required'
            ],
            [
                'job_type_code.required' => 'Job type code is required.',
                'job_type_code.unique' => 'Job type code already exists.',
                'job_type_name.required' => 'Job type name is required.',
                'job_type_name.unique' => 'Job type already exists.',
                'status.required' => 'Please select status.'
            ]
        );


        JobType::create([
            'job_type_code' => $request->job_type_code,
            'job_type_name' => $request->job_type_name,
            'description' => $request->description,
            'status' => $request->status,
            'created_by' => 1
        ]);


        return redirect()->route('admin.job-type.index')
            ->with('success', 'Job Type added successfully');
    }

    public function edit($id)
    {
        $jobType = JobType::findOrFail($id);
        return view('admin.masters.job_type.edit', compact('jobType'));
    }

    public function update(Request $request, $id)
    {
        $jobType = JobType::findOrFail($id);

        $request->validate(
            [
                'job_type_code' => "required|max:50|unique:job_type_master,job_type_code,$id",
                'job_type_name' => "required|max:100|unique:job_type_master,job_type_name,$id",
                'status' => 'required'
            ],
            [
                'job_type_code.required' => 'Job type code is required.',
                'job_type_code.unique' => 'Job type code already exists.',
                'job_type_name.required' => 'Job type name is required.',
                'job_type_name.unique' => 'Job type already exists.',
                'status.required' => 'Please select status.'
            ]
        );


        $jobType->update([
            'job_type_code' => $request->job_type_code,
            'job_type_name' => $request->job_type_name,
            'description' => $request->description,
            'status' => $request->status,
            'updated_by' => 1
        ]);

        return redirect()->route('admin.job-type.index')
            ->with('success', 'Job Type updated successfully');
    }



    public function destroy($id)
    {
        $jobType = JobType::findOrFail($id);
        $jobType->delete();

        return redirect()->route('admin.job-type.index')
            ->with('success', 'Job Type deleted successfully');
    }

    public function trash()
    {
        $jobTypes = JobType::onlyTrashed()->get();
        return view('masters.job_type.trash', compact('jobTypes'));
    }

    public function restore($id)
    {
        JobType::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.job-type.trash')
            ->with('success', 'Job Type restored');
    }

    public function forceDelete($id)
    {
        JobType::withTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.job-type.trash')
            ->with('success', 'Job Type removed permanently');
    }

    //API

    public function apiIndex(Request $request)
    {
        $query = JobType::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $data = $query->orderBy('job_type_name')->get();

        return ApiResponse::success($data, 'Job types fetched');
    }


    public function apiStore(Request $request)
    {
        $request->validate([
            'job_type_code' => 'required|max:20|unique:job_type_master,job_type_code',
            'job_type_name' => 'required|max:100',
            'status' => 'required'
        ]);

        $data = JobType::create([
            'id' => Str::uuid(),
            'job_type_code' => $request->job_type_code,
            'job_type_name' => $request->job_type_name,
            'description' => $request->description,
            'status' => $request->status,
            'created_by' => 1
        ]);

        return ApiResponse::success($data, 'Job type created successfully');
    }


    public function apiUpdate(Request $request, $id)
    {
        $data = JobType::findOrFail($id);

        $data->update([
            'job_type_name' => $request->job_type_name,
            'status' => $request->status,
            'updated_by' => 1
        ]);

        return ApiResponse::success($data, 'Job type updated');
    }

    public function apiDelete($id)
    {
        $data = JobType::findOrFail($id);
        $data->delete();

        return ApiResponse::success(null, 'Job type deleted');
    }

    public function apiDeleted()
    {
        $data = JobType::onlyTrashed()->get();
        return ApiResponse::success($data, 'Deleted job types fetched');
    }

    public function apiRestore($id)
    {
        $data = JobType::withTrashed()->findOrFail($id);
        $data->restore();

        return ApiResponse::success($data, 'Job type restored');
    }

    public function apiForceDelete($id)
    {
        $data = JobType::withTrashed()->findOrFail($id);
        $data->forceDelete();

        return ApiResponse::success(null, 'Job type permanently deleted');
    }


}
