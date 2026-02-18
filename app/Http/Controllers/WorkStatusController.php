<?php

namespace App\Http\Controllers;

use App\Models\WorkStatus;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Str;

class WorkStatusController extends Controller
{
    public function index()
    {
        $workStatuses = WorkStatus::latest()->get();
        return view('masters.work_status.index', compact('workStatuses'));
    }

    public function create()
    {
        return view('masters.work_status.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'work_status_code' => 'required|max:50|unique:work_status_master,work_status_code',
            'work_status_name' => 'required|max:100',
            'status' => 'required'
        ]);

        WorkStatus::create([
            'work_status_code' => $request->work_status_code,
            'work_status_name' => $request->work_status_name,
            'description' => $request->description,
            'status' => $request->status,
            'created_by' => 1, // later: Auth::id()
        ]);

        return redirect()->route('admin.work-status.index')
            ->with('success', 'Work Status added successfully');
    }

    public function edit($id)
    {
        $workStatus = WorkStatus::findOrFail($id);
        return view('masters.work_status.edit', compact('workStatus'));
    }

    public function update(Request $request, $id)
    {
        $workStatus = WorkStatus::findOrFail($id);

        $request->validate([
            'work_status_code' => "required|max:50|unique:work_status_master,work_status_code,{$id},id",
            'work_status_name' => 'required|max:100',
            'status' => 'required'
        ]);

        $workStatus->update([
            'work_status_code' => $request->work_status_code,
            'work_status_name' => $request->work_status_name,
            'description' => $request->description,
            'status' => $request->status,
            'updated_by' => 1,
        ]);

        return redirect()->route('admin.work-status.index')
            ->with('success', 'Work Status updated successfully');
    }

    public function destroy($id)
    {
        $workStatus = WorkStatus::findOrFail($id);
        $workStatus->delete();

        return redirect()->route('admin.work-status.index')
            ->with('success', 'Work Status deleted successfully');
    }

    public function trash()
    {
        $workStatuses = WorkStatus::onlyTrashed()->latest()->get();
        return view('masters.work_status.trash', compact('workStatuses'));
    }

    public function restore($id)
    {
        WorkStatus::withTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.work-status.trash')
            ->with('success', 'Work Status restored');
    }

    public function forceDelete($id)
    {
        WorkStatus::withTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('admin.work-status.trash')
            ->with('success', 'Work Status removed permanently');
    }

    // API

    public function apiIndex()
    {
        $data = WorkStatus::where('status', 'Active')->get();
        return ApiResponse::success($data, 'Work status fetched');
    }

    public function apiStore(Request $request)
    {
        $request->validate([
            'work_status_name' => 'required|max:100',
            'status' => 'required'
        ]);

        $data = WorkStatus::create([
            'id' => Str::uuid(),
            'work_status_name' => $request->work_status_name,
            'status' => $request->status,
            'created_by' => 1,
        ]);

        return ApiResponse::success($data, 'Work status created');
    }

    public function apiUpdate(Request $request, $id)
    {
        $data = WorkStatus::findOrFail($id);

        $request->validate([
            'work_status_name' => 'required|max:100',
            'status' => 'required',
        ]);

        $data->update([
            'work_status_name' => $request->work_status_name,
            'status' => $request->status,
            'updated_by' => 1,
        ]);

        return ApiResponse::success($data, 'Work status updated');
    }

    public function apiDelete($id)
    {
        $data = WorkStatus::findOrFail($id);
        $data->delete();

        return ApiResponse::success(null, 'Work status deleted');
    }
}
