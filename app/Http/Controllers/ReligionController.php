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
        $request->validate([
            'religion_name' => 'required|max:100|unique:religion_master',
            'status' => 'required'
        ]);

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
        return view('masters.religion.edit', compact('religion'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'religion_name' => "required|max:100|unique:religion_master,religion_name,$id",
            'status' => 'required'
        ]);

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
        return view('masters.religion.trash', compact('religions'));
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

    public function apiIndex()
    {
        $data = Religion::where('status', 'Active')->get();
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


}
