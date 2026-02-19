<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Religion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Support\Str;

class ReligionController extends Controller
{
    public function index()
    {
        $religions = Religion::latest()->get();
        return view('admin.masters.religion.index', compact('religions'));
    }

    public function create()
    {
        return view('admin.masters.religion.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'religion_name' => 'required|max:100|unique:religion_master,religion_name',
                'status' => 'required'
            ],
            [
                'religion_name.required' => 'Religion name is required.',
                'religion_name.unique' => 'This religion already exists.',
                'status.required' => 'Please select status.'
            ]
        );


        Religion::create([
            'religion_name' => $request->religion_name,
            'status' => $request->status,
            'created_by' => 1
        ]);

        return redirect()->route('admin.religion.index')
            ->with('success', 'Religion added successfully');
    }

    public function edit($id)
    {
        $religion = Religion::findOrFail($id);
        return view('admin.masters.religion.edit', compact('religion'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'religion_name' => "required|max:100|unique:religion_master,religion_name,$id",
                'status' => 'required'
            ],
            [
                'religion_name.required' => 'Religion name is required.',
                'religion_name.unique' => 'This religion already exists.',
                'status.required' => 'Please select status.'
            ]
        );


        $religion = Religion::findOrFail($id);

        $religion->update([
            'religion_name' => $request->religion_name,
            'status' => $request->status,
            'updated_by' => 1
        ]);

        return redirect()->route('admin.religion.index')
            ->with('success', 'Religion updated successfully');
    }

    public function destroy($id)
    {
        $religion = Religion::findOrFail($id);
        $religion->delete();

        return redirect()->route('admin.religion.index')
            ->with('success', 'Religion deleted successfully');
    }


    public function trash()
    {
        $religions = Religion::onlyTrashed()->get();
        return view('admin.masters.religion.trash', compact('religions'));
    }

    public function restore($id)
    {
        Religion::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.religion.trash')->with('success', 'Religion restored');
    }

    public function forceDelete($id)
    {
        Religion::withTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.religion.trash')->with('success', 'Religion removed permanently');
    }

    //API

    public function apiIndex(Request $request)
    {
        $query = Religion::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $data = $query->orderBy('religion_name')->get();

        return ApiResponse::success($data, 'Religion list fetched');
    }


    public function apiStore(Request $request)
    {
        $request->validate([
            'religion_name' => 'required|max:100',
            'status' => 'required'
        ]);

        $data = Religion::create([
            'id' => Str::uuid(),
            'religion_name' => $request->religion_name,
            'status' => $request->status,
            'created_by' => 1
        ]);

        return ApiResponse::success($data, 'Religion created');
    }

    public function apiUpdate(Request $request, $id)
    {
        $data = Religion::findOrFail($id);

        $data->update([
            'religion_name' => $request->religion_name,
            'status' => $request->status,
            'updated_by' => 1
        ]);

        return ApiResponse::success($data, 'Religion updated');
    }

    public function apiDelete($id)
    {
        $data = Religion::findOrFail($id);
        $data->delete();

        return ApiResponse::success(null, 'Religion deleted');
    }
    public function apiDeleted()
    {
        $data = Religion::onlyTrashed()->get();
        return ApiResponse::success($data, 'Deleted religions fetched');
    }

    public function apiRestore($id)
    {
        $data = Religion::withTrashed()->findOrFail($id);
        $data->restore();

        return ApiResponse::success($data, 'Religion restored');
    }

    public function apiForceDelete($id)
    {
        $data = Religion::withTrashed()->findOrFail($id);
        $data->forceDelete();

        return ApiResponse::success(null, 'Religion permanently deleted');
    }


}
