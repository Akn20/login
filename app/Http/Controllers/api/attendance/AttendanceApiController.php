<?php

namespace App\Http\Controllers\Api\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AttendanceRecord;
use App\Models\Shift;
use Carbon\Carbon;
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
    public function report(Request $request)
{
    try {

        /*
        =====================================================
        DAILY REPORT
        =====================================================
        */

        if ($request->filled('date')) {

            $query = AttendanceRecord::with([
                'staff.department',
                'staff.designation',
                'shift'
            ]);

            /*
            DATE FILTER
            */

            $query->whereDate(
                'attendance_date',
                $request->date
            );

            /*
            DEPARTMENT FILTER
            */

            if ($request->filled('department')) {

                $query->whereHas('staff.department', function ($q) use ($request) {
                    $q->where('id', $request->department);
                });
            }

            /*
            DESIGNATION FILTER
            */

            if ($request->filled('designation')) {

                $query->whereHas('staff.designation', function ($q) use ($request) {
                    $q->where('id', $request->designation);
                });
            }

            $records = $query->orderBy(
                'attendance_date',
                'desc'
            )->get();

            /*
            FORMAT DAILY RESPONSE
            */

            $data = $records->map(function ($record) {

                return [

                    'id' => $record->id,

                    'employeeName' =>
                        $record->staff->employee_name
                        ?? $record->staff->name
                        ?? '',

                    'department' =>
                        $record->staff->department->department_name
                        ?? '',

                    'designation' =>
                        $record->staff->designation->designation_name
                        ?? '',

                    'shift' =>
                        $record->shift->shift_name
                        ?? '',

                    'checkIn' =>
                        $record->check_in ?? '',

                    'checkOut' =>
                        $record->check_out ?? '',

                    'status' =>
                        ucfirst($record->status ?? 'Absent'),

                    'lateEntry' =>
                        (int) ($record->late_minutes ?? 0),

                    'overtime' =>
                        (int) ($record->overtime_minutes ?? 0),
                ];
            });

            return response()->json([
                'success' => true,
                'count' => $data->count(),
                'data' => $data
            ]);
        }

        /*
        =====================================================
        MONTHLY REPORT
        =====================================================
        */

        if ($request->filled('month')) {
        $date = Carbon::createFromFormat('Y-m', $request->month);

        $month = $date->month;
        $year  = $date->year;
            $query = AttendanceRecord::with([
                'staff.department',
                'staff.designation'
            ])

            ->whereMonth('attendance_date', $month)
            ->whereYear('attendance_date', $year);

            /*
            DEPARTMENT FILTER
            */

            if ($request->filled('department')) {

                $query->whereHas('staff.department', function ($q) use ($request) {
                    $q->where('id', $request->department);
                });
            }

            /*
            DESIGNATION FILTER
            */

            if ($request->filled('designation')) {

                $query->whereHas('staff.designation', function ($q) use ($request) {
                    $q->where('id', $request->designation);
                });
            }

            $records = $query->get();

            /*
            GROUP BY EMPLOYEE
            */

            $grouped = $records->groupBy(function ($record) {
                return $record->staff->id;
            });

            /*
            FORMAT MONTHLY SUMMARY
            */

            $data = $grouped->map(function ($items) {

                $staff = $items->first()->staff;

                return [

                    'employeeName' =>
                        $staff->employee_name
                        ?? $staff->name
                        ?? '',

                    'present' =>
                        $items->where('status', 'Present')->count(),

                    'absent' =>
                        $items->where('status', 'Absent')->count(),

                    'leave' =>
                        $items->where('status', 'Leave')->count(),

                    'lateEntries' =>
                        $items->where('late_minutes', '>', 0)->count(),

                    'overtime' =>
                        $items->sum('overtime_minutes'),
                ];
            })->values();

            return response()->json([
                'success' => true,
                'count' => $data->count(),
                'data' => $data
            ]);
        }

        /*
        DEFAULT EMPTY
        */

        return response()->json([
            'success' => true,
            'count' => 0,
            'data' => []
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
}