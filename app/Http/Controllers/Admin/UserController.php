<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use App\Models\User;

use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->where('deleted_at', null)->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Roles::where('status', 'active')->get();
        return view('admin.users.create', compact('roles'));
    }
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'mobile' => 'required|digits:10|unique:users,mobile',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:active,inactive'
        ]);

        User::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'status' => $request->status
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        $roles = Roles::where('status', 'active')->get();
        return view('admin.users.edit', compact('roles', 'user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string',
            'mobile' => 'sometimes|required|digits:10|unique:users,mobile,',
            'role_id' => 'sometimes|required|exists:roles,id',
            'status' => 'sometimes|required|in:active,inactive'
        ]);

        $user->update($request->only('name', 'mobile', 'email', 'role_id', 'status'));

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }

    public function displayDeletedUser()
    {

        $users = User::withTrashed()->where('deleted_at', '!=', null)->latest()->paginate(10);
        // if($deletedUsers->isEmpty()){
        //     return redirect()->back()->with('error', 'No deleted users found');
        // }   
        return view('admin.users.deleted', compact('users'));
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }
        $user->restore();

        return redirect()->route('admin.users.index')->with('success', 'User restored successfully');
    }

    public function forceDeleteUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }
        $user->forceDelete();
        return redirect()->route('admin.users.deleted')->with('success', 'User permanently deleted');
    }

    public function toggleStatus(User $user)
    {
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        return response()->json([
            'success' => true,
            'status' => $user->status,
        ]);
    }

}


