<?php

namespace App\Http\Controllers\Admin\Nurse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NurseShifts;
use Illuminate\Support\Facades\DB;

class NurseShiftsController extends Controller
{
    public function index()
    {
        $shifts = DB::table('shift_assignments')
            ->join('shifts', 'shift_assignments.shift_id', '=', 'shifts.id')
            
            ->join('staff', 'shift_assignments.staff_id', '=', 'staff.id')
            ->join('users', 'staff.user_id', '=', 'users.id')
            ->leftJoin('roles', 'staff.role_id', '=', 'roles.id')

            //  Only nurses
            ->where('roles.name', 'Nurse')

            ->select(
                'shift_assignments.id',
                'users.name as nurse_name',
                'shifts.shift_name',
                'shifts.start_time',
                'shifts.end_time',
                'shift_assignments.start_date',
                'shift_assignments.end_date'
            )
            ->get();

        return view('admin.nurse.NurseShift.index', compact('shifts'));
    }


    public function show($id)
    {
        $shift = DB::table('shift_assignments')
            ->join('shifts', 'shift_assignments.shift_id', '=', 'shifts.id')
            ->join('staff', 'shift_assignments.staff_id', '=', 'staff.id')
            ->join('users', 'staff.user_id', '=', 'users.id')
            ->leftJoin('roles', 'staff.role_id', '=', 'roles.id')
            ->where('shift_assignments.id', $id) 
            ->select(
                'shift_assignments.id',
                'users.name as nurse_name',
                'shifts.shift_name',
                'shifts.start_time',
                'shifts.end_time',
                'shift_assignments.start_date',
                'shift_assignments.end_date'
            )
            ->first();

        if (!$shift) {
            abort(404); 
        }

        $entries = NurseShifts::where('shift_assignment_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.nurse.NurseShift.show', compact('shift', 'entries'));
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'shift_assignment_id' => 'required',
            'entry_type' => 'required',
            'description' => 'required'
        ]);

        NurseShifts::create([
            'hospital_id' => null,
            'nurse_id' => auth()->id(),
            'shift_assignment_id' => $request->shift_assignment_id,
            'entry_type' => $request->entry_type,
            'description' => $request->description,
            'task_status' => $request->entry_type == 'task' ? $request->task_status : null,
        ]);

        return redirect()->back()->with('success', 'Entry added successfully');
    }

    public function create($id)
    {
        $shift = DB::table('shift_assignments')
            ->where('id', $id)
            ->first();

        if (!$shift) {
            abort(404);
        }

        return view('admin.nurse.NurseShift.create', compact('shift'));
    }

    public function markComplete($id)
    {
        $entry = NurseShifts::find($id);

        if (!$entry) {
            abort(404);
        }

        $entry->update([
            'task_status' => 'completed'
        ]);

        return redirect()->back()->with('success', 'Marked as completed');
    }

    // API
    public function apiIndex()
    {
        $shifts = DB::table('shift_assignments')
            ->join('shifts', 'shift_assignments.shift_id', '=', 'shifts.id')
            ->join('staff', 'shift_assignments.staff_id', '=', 'staff.id')
            ->join('users', 'staff.user_id', '=', 'users.id')
            ->leftJoin('roles', 'staff.role_id', '=', 'roles.id')
            ->where('roles.name', 'Nurse')
            ->select(
                'shift_assignments.id',
                'users.name as nurse_name',
                'shifts.shift_name',
                'shifts.start_time',
                'shifts.end_time',
                'shift_assignments.start_date',
                'shift_assignments.end_date'
            )
            ->get();

        return response()->json([
            'status' => true,
            'data' => $shifts
        ]);
    }

    public function apiShow($id)
    {
        $shift = DB::table('shift_assignments')
            ->join('shifts', 'shift_assignments.shift_id', '=', 'shifts.id')
            ->join('staff', 'shift_assignments.staff_id', '=', 'staff.id')
            ->join('users', 'staff.user_id', '=', 'users.id')
            ->leftJoin('roles', 'staff.role_id', '=', 'roles.id')
            ->where('shift_assignments.id', $id)
            ->select(
                'shift_assignments.id',
                'users.name as nurse_name',
                'shifts.shift_name',
                'shifts.start_time',
                'shifts.end_time',
                'shift_assignments.start_date',
                'shift_assignments.end_date'
            )
            ->first();

        if (!$shift) {
            return response()->json([
                'status' => false,
                'message' => 'Shift not found'
            ], 404);
        }

        $entries = NurseShifts::where('shift_assignment_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'shift' => $shift,
            'entries' => $entries
        ]);
    }

    public function apiStore(Request $request)
    {
        $request->validate([
            'shift_assignment_id' => 'required',
            'entry_type' => 'required',
            'description' => 'required'
        ]);

        // Get nurse_id from shift
        $staff = DB::table('shift_assignments')
            ->join('staff', 'shift_assignments.staff_id', '=', 'staff.id')
            ->where('shift_assignments.id', $request->shift_assignment_id)
            ->select('staff.user_id')
            ->first();

        if (!$staff) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid shift'
            ], 404);
        }

        $entry = NurseShifts::create([
            'hospital_id' => null,
            'nurse_id' => $staff->user_id, 
            'shift_assignment_id' => $request->shift_assignment_id,
            'entry_type' => $request->entry_type,
            'description' => $request->description,
            'task_status' => 'pending'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Handover added successfully',
            'data' => $entry
        ]);
    }

    public function apiMarkComplete($id)
    {
        $entry = NurseShifts::find($id);

        if (!$entry) {
            return response()->json([
                'status' => false,
                'message' => 'Entry not found'
            ], 404);
        }

        $entry->update([
            'task_status' => 'completed'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Marked as completed'
        ]);
    }
}