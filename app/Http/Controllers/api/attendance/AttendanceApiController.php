<?php

namespace App\Http\Controllers\Api\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AttendanceRecord;
use App\Models\Shift;
use App\Helpers\ApiResponse;
use App\Http\Resources\AttendanceResource;

class AttendanceApiController extends Controller
{

    /* ---------------------------
    GET ALL ATTENDANCE
    ---------------------------- */

 public function index()
{

$attendance = AttendanceRecord::with([
    'staff.department',
    'staff.designation',
    'shift'
])->latest()->get();

return AttendanceResource::collection($attendance);

}


    /* ---------------------------
    CREATE ATTENDANCE
    ---------------------------- */

    public function store(Request $request)
    {

        $data = $request->validate([

            'employee_id' => 'required',
            'department_id' => 'required',
            'designation_id' => 'required',
            'shift_id' => 'required',
            'attendance_date' => 'required|date',
            'status' => 'required'

        ]);

        $attendance = AttendanceRecord::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Attendance created successfully',
            'data' => $attendance
        ]);

    }


    /* ---------------------------
    SHOW SINGLE RECORD
    ---------------------------- */

    public function show($id)
{

$attendance = AttendanceRecord::with([
    'staff.department',
    'staff.designation',
    'shift'
])->findOrFail($id);

return new AttendanceResource($attendance);

}

    /* ---------------------------
    UPDATE ATTENDANCE
    ---------------------------- */

    public function update(Request $request,$id)
    {

        $attendance = AttendanceRecord::findOrFail($id);

        $attendance->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Attendance updated successfully',
            'data' => $attendance
        ]);

    }


    /* ---------------------------
    DELETE ATTENDANCE
    ---------------------------- */

    public function destroy($id)
    {

        $attendance = AttendanceRecord::findOrFail($id);

        $attendance->delete();

        return response()->json([
            'success' => true,
            'message' => 'Attendance deleted successfully'
        ]);

    }


    /* ---------------------------
    LATE ENTRIES
    ---------------------------- */

    public function lateEntries()
    {

        $records = AttendanceRecord::where('late_minutes','>',0)
                    ->with(['staff','shift'])
                    ->get();

        return response()->json([
            'success' => true,
            'data' => $records
        ]);

    }


    /* ---------------------------
    OVERTIME RECORDS
    ---------------------------- */

    public function overtime()
    {

        $records = AttendanceRecord::where('overtime_minutes','>',0)
                    ->with(['staff','shift'])
                    ->get();

        return response()->json([
            'success' => true,
            'data' => $records
        ]);

    }

}