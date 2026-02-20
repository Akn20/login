<?php

namespace App\Http\Controllers;

use App\Models\BloodGroup;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Helpers\ApiResponse;
use Illuminate\Support\Str;


class BloodGroupController extends Controller
{

    public function index()
    {
        $bloodGroups = BloodGroup::orderBy('admin.blood_group_name')->paginate(10);
        return view('admin.masters.blood-groups.index', compact('bloodGroups'));
    }


    public function create()
    {
        return view('admin.masters.blood-groups.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'blood_group_name' => [
                'required',
                Rule::unique('blood_group_master', 'blood_group_name')->whereNull('deleted_at'),
            ],

            'status' => ['required', Rule::in(['Active', 'Inactive'])],
        ]);

        BloodGroup::create([
            'blood_group_name' => strtoupper($request->blood_group_name),
            'status' => $request->status,
            'created_by' => auth()->id() ?? 1,
        ]);

        return redirect()->route('blood-groups.index')->with('success', 'Blood group added.');
    }

    public function edit(string $id)
    {
        $bloodGroup = BloodGroup::findOrFail($id);
        return view('admin.masters.blood-groups.edit', compact('bloodGroup'));
    }


    public function update(Request $request, string $id)
    {
        $bloodGroup = BloodGroup::findOrFail($id);

        $request->validate([
            'blood_group_name' => [
                'required',
            ],

            'status' => ['required', Rule::in(['Active', 'Inactive'])],
        ]);

        $bloodGroup->update([
            'blood_group_name' => strtoupper($request->blood_group_name),
            'status' => $request->status,
            'updated_by' => auth()->id() ?? 1,
        ]);

        return redirect()->route('blood-groups.index')->with('success', 'Blood group updated.');

    }


    public function destroy(string $id)
    {
        $bloodGroup = BloodGroup::findOrFail($id);
        $bloodGroup->delete();

        return back()->with('success', 'Blood group deleted.');
    }

    public function deletedHistory()
    {
        $bloodGroups = BloodGroup::onlyTrashed()
            ->orderBy('blood_group_name')
            ->paginate(10);

        return view('masters.blood-groups.deleted', compact('bloodGroups'));
    }

    public function restore(string $id)
    {
        $bloodGroup = BloodGroup::onlyTrashed()->findOrFail($id);
        $bloodGroup->restore();

        return redirect()->route('blood-groups.deleted')->with('success', 'Blood group restored successfully.');
    }

    public function forceDelete(string $id)
    {
        $bloodGroup = BloodGroup::onlyTrashed()->findOrFail($id);
        $bloodGroup->forceDelete();

        return redirect()->route('blood-groups.deleted')->with('success', 'Blood group permanently deleted.');
    }

    //API

    public function apiIndex(Request $request)
    {
        $query = BloodGroup::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $data = $query->orderBy('blood_group_name')->get();

        return ApiResponse::success($data, 'Blood groups fetched');
    }


    public function apiStore(Request $request)
    {
        $request->validate([
            'blood_group_name' => 'required|max:10',
            'status' => 'required'
        ]);

        $data = BloodGroup::create([
            'id' => Str::uuid(),
            'blood_group_name' => $request->blood_group_name,
            'status' => $request->status,
            'created_by' => 1
        ]);

        return ApiResponse::success($data, 'Blood group created');
    }

    public function apiUpdate(Request $request, $id)
    {
        $data = BloodGroup::findOrFail($id);

        $data->update([
            'blood_group_name' => $request->blood_group_name,
            'status' => $request->status,
            'updated_by' => 1
        ]);

        return ApiResponse::success($data, 'Blood group updated');
    }

    public function apiDelete($id)
    {
        $data = BloodGroup::findOrFail($id);
        $data->delete();

        return ApiResponse::success(null, 'Blood group deleted');
    }

    public function apiDeleted()
    {
        $data = BloodGroup::onlyTrashed()->get();
        return ApiResponse::success($data, 'Deleted blood groups fetched');
    }

    public function apiRestore($id)
    {
        $data = BloodGroup::withTrashed()->findOrFail($id);
        $data->restore();

        return ApiResponse::success($data, 'Blood group restored');
    }

    public function apiForceDelete($id)
    {
        $data = BloodGroup::withTrashed()->findOrFail($id);
        $data->forceDelete();

        return ApiResponse::success(null, 'Blood group permanently deleted');
    }



}
