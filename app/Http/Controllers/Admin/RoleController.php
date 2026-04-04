<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Roles::orderBy('name')->where('deleted_at', null)->latest()->paginate(10);
        if(request()->wantsJson()){
            $roles= Roles::orderBy('name')->where('deleted_at', null)->latest()->get();
            return response()->json($roles);
        }
        if ($roles->isEmpty()) {
            return response()->json(['message' => 'No roles found'], 404);
        }
        return view('admin.roles.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        Roles::create($request->all());
        if(request()->wantsJson()){
            return response()->json(['message' => 'Role created successfully']);
        }
        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully');
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function edit(Roles $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $role = Roles::findOrFail($id);
        if (!$role) {
            return redirect()->back()->with('error', 'Role not found');
        }

        $request->validate([
            'name' => 'sometimes|required',
            'description' => 'nullable|string',
            'status' => 'in:active,inactive'
        ]);

        $role->update($request->all());
        if(request()->wantsJson()){
            return response()->json(['message' => 'Role updated successfully']);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully');
    }



    public function destroy($id)
    {
        $role = Roles::findOrFail($id);
        if (!$role) {
            return redirect()->back()->with('error', 'Role not found');
        }
        $role->delete();
        if(request()->wantsJson()){
            return response()->json(['message' => 'Role deleted successfully']);
        }
        return redirect()->back()->with('success', 'Role deleted successfully');
    }

    public function displayDeletedRoles()
    {
        $deletedRoles = Roles::withTrashed()->whereNotNull('deleted_at')->latest()->paginate(10);
        if(request()->wantsJson()){
            $deletedRoles= Roles::withTrashed()->whereNotNull('deleted_at')->latest()->get();
            return response()->json($deletedRoles);
        }
        return view('admin.roles.deleted')->with('roles', $deletedRoles);
    }

    public function restore($id)
    {

        $role = Roles::withTrashed()->findOrFail($id);
        if (!$role) {
            return redirect()->back()->with('error', 'Role not found');
        }
        $role->restore();
        if(request()->wantsJson()){
            return response()->json(['message' => 'Role restored successfully']);
        }
        return redirect()->route('admin.roles.deleted')->with('success', 'Role restored successfully');
    }

    public function forceDeleteRole($id)
    {

        $role = Roles::withTrashed()->findOrFail($id);
        if (!$role) {
            return redirect()->back()->with('error', 'Role not found');
        }
        $role->forceDelete();
        if(request()->wantsJson()){
            return response()->json(['message' => 'Role permanently deleted successfully']);
        }
        return redirect()->route('admin.roles.deleted')->with('success', 'Role permanently deleted successfully');
    }

    public function toggleStatus(Request $request)
    {
        $role = Roles::findOrFail($request->id);
        if($role->name=='admin'){
            return response()->json([
                'success' => false,
                'message' => 'Cannot change status of Admin role',
            ], 403);
        }
        $role->status = $role->status === 'active' ? 'inactive' : 'active';
        $role->save();

        return response()->json([
            'success' => true,
            'status' => $role->status,
        ]);
    }
}
