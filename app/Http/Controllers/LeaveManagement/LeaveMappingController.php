<?php

namespace App\Http\Controllers\LeaveManagement;

use App\Http\Controllers\Controller;
use App\Models\LeaveMapping;
use App\Models\LeaveType; 
use Illuminate\Http\Request;

class LeaveMappingController extends Controller
{
    public function index()
    {
        
        $mappings = LeaveMapping::with('leaveType')->get();
        return view('admin.Leave_Management.leave_mappings.index', compact('mappings'));
    }

    public function create()
    {
        $leaveTypes = LeaveType::all(); 
        return view('admin.Leave_Management.leave_mappings.create', compact('leaveTypes'));
    }

    public function store(Request $request)
    {
        // Sync web checkbox to 'active'/'inactive' string
        if (!$request->wantsJson()) {
            $request->merge(['status' => $request->has('status') ? 'active' : 'inactive']);
        }

        $data = $request->validate([
            'leave_type_id' => 'required|uuid',
            'priority' => 'required|integer',
            'employee_status' => 'required|array', 
            'accrual_frequency' => 'required|in:Monthly,Yearly,Event Based', 
            'status' => 'required|in:active,inactive', 
        ]);

        $mapping = LeaveMapping::create($data);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $mapping]);
        }

        return redirect()->route('admin.leave-mappings.index')->with('success', 'Mapping created!');
    }
}