<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use App\Models\User;

use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Http\Request;
use Log;

class UserController extends Controller
{
    public function index()
    {
        if(request()->wantsJson()){
            return User::with('role')->where('deleted_at', null)->latest()->get();
        }
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
        if(request()->wantsJson()){
            return response()->json(['message' => 'User created successfully']);
        }
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
            'mobile' => 'sometimes|required|digits:10|unique:users,mobile,'.$id,
            'role_id' => 'sometimes|required|exists:roles,id',
            'status' => 'sometimes|required|in:active,inactive'
        ]);

        $user->update($request->only('name', 'mobile', 'email', 'role_id', 'status'));
        if(request()->wantsJson()){
            return response()->json(['message' => 'User updated successfully']);
        }
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }
        $user->delete();
        if(request()->wantsJson()){
            return response()->json(['message' => 'User deleted successfully']);
        }
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }

    public function displayDeletedUser()
    {

        $users = User::withTrashed()->where('deleted_at', '!=', null)->latest()->paginate(10);
        if(request()->wantsJson()){
            return User::withTrashed()->where('deleted_at', '!=', null)->latest()->get();
        }  
        return view('admin.users.deleted', compact('users'));
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }
        $user->restore();
        if(request()->wantsJson()){
            return response()->json(['message' => 'User restored successfully']);
        }   
        return redirect()->route('admin.users.index')->with('success', 'User restored successfully');
    }

    public function forceDeleteUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }
        $user->forceDelete();
        if(request()->wantsJson()){
            return response()->json(['message' => 'User permanently deleted']);
        }
        return redirect()->route('admin.users.deleted')->with('success', 'User permanently deleted');
    }

    public function toggleStatus(Request $request)
    {
        $user=User::findOrFail($request->id);
        if($user->role->name == 'admin'){
            return response()->json([
                'success' => false,
                'message' => 'Cannot change status of Admin user',
            ], 403);
        }
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        return response()->json([
            'success' => true,
            'status' => $user->status,
        ]);
    }
    public function notEnrolled(){
        $users = User::where('is_enrolled', false)->get();
        return response()->json($users);
    }
    

}


