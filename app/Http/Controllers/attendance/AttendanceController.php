<?php

namespace App\Http\Controllers\attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Shift;
use App\Models\AttendanceRecord;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    

    public function index()
        {

        $attendance = AttendanceRecord::with(['staff','shift'])
                    ->latest()
                    ->paginate(10);

        return view(
            'attendance.index',
            compact('attendance')
        );
}
public function destroy($id)
{
    try {

        $attendance = AttendanceRecord::findOrFail($id);

        $attendance->delete();

        return response()->json([
            'success' => true,
            'message' => 'Attendance deleted successfully'
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);

    }
}public function overtimeRecords(Request $request)
{
    try {

        $query = AttendanceRecord::with([
            'staff',
            'shift',
            'department',
            'designation'
        ]);

        // Filter by department
        if ($request->department_id) {
            $query->where('department_id', $request->department_id);
        }

        // Filter by designation
        if ($request->designation_id) {
            $query->where('designation_id', $request->designation_id);
        }

        // Optional: only overtime employees
        $query->where('overtime_minutes', '>', 0);

        $records = $query->get();

        $data = $records->map(function ($item) {

            $minutes = $item->overtime_minutes ?? 0;

            return [
                'id' => $item->id,
                'employeeName' => $item->staff->name ?? '',
                'department' => $item->department->department_name ?? '',
                'designation' => $item->designation->designation_name ?? '',
                'shiftEnd' => $item->shift->end_time ?? '',
                'checkOut' => $item->check_out ?? '',
                'overtimeMinutes' => $minutes,
                'overtimeDuration' =>
                    floor($minutes / 60) . "h " .
                    ($minutes % 60) . "m",
            ];
        });

        return response()->json([
            'success' => true,
            'count' => $data->count(),
            'data' => $data
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
    public function create()
    {
        $departments = Department::pluck('department_name','id');
        $designations = Designation::pluck('designation_name','id');
        $staff = Staff::pluck('name','id');
        $shifts = Shift::pluck('shift_name','id');

        return view('attendance.create', compact(
            'departments',
            'designations',
            'staff',
            'shifts'
        ));
    }

    public function store(Request $request)
{

$request->validate([
    'employee_id' => 'required',
    'department_id' => 'required',
    'designation_id' => 'required',
    'shift_id' => 'required',
    'attendance_date' => 'required|date',
]);

$shift = Shift::findOrFail($request->shift_id);

$checkIn = $request->check_in;
$checkOut = $request->check_out;

$shiftStart = $shift->start_time;
$shiftEnd = $shift->end_time;

$lateMinutes = 0;
$overtimeMinutes = 0;

/* -------- LATE ENTRY CALCULATION -------- */

if($checkIn){

    $checkInTime = Carbon::parse($checkIn);
    $shiftStartTime = Carbon::parse($shiftStart);

    if($checkInTime->gt($shiftStartTime)){

        $lateMinutes = $shiftStartTime->diffInMinutes($checkInTime);

    }

}

/* -------- OVERTIME CALCULATION -------- */

if($checkOut){

    $checkOutTime = Carbon::parse($checkOut);
    $shiftEndTime = Carbon::parse($shiftEnd);

    if($checkOutTime->gt($shiftEndTime)){

        $overtimeMinutes = $shiftEndTime->diffInMinutes($checkOutTime);

    }

}

/* -------- SAVE ATTENDANCE -------- */

AttendanceRecord::create([

    'employee_id' => $request->employee_id,
    'department_id' => $request->department_id,
    'designation_id' => $request->designation_id,
    'shift_id' => $request->shift_id,
    'attendance_date' => $request->attendance_date,
    'check_in' => $checkIn,
    'check_out' => $checkOut,
    'status' => $request->status,
    'late_minutes' => $lateMinutes,
    'overtime_minutes' => $overtimeMinutes,

]);

return redirect()
    ->route('hr.attendance.index')
    ->with('success', 'Attendance recorded successfully');

}
        public function getDesignations($department_id)
        {

        $designations = Designation::where('department_id',$department_id)
                        ->pluck('designation_name','id');

        return response()->json($designations);

        }
public function getEmployees($designation_id)
{
    $employees = Staff::where('designation_id', $designation_id)
                ->pluck('name','id');

    return response()->json($employees);
}
        public function getShiftTime($id)
        {
            $shift = Shift::findOrFail($id);

            return response()->json([
                'start_time' => $shift->start_time,
                'end_time' => $shift->end_time
            ]);
        }
        public function lateEntries(Request $request)
        {

        $query = AttendanceRecord::with(['staff','shift']);

        /* ONLY LATE EMPLOYEES */

        $query->where('late_minutes','>',0);

        /* FILTER BY DEPARTMENT */

        if($request->department_id){

        $query->where('department_id',$request->department_id);

        }

        /* FILTER BY DESIGNATION */

        if($request->designation_id){

        $query->where('designation_id',$request->designation_id);

        }

        $lateEntries = $query->latest()->paginate(10);

        /* LOAD FILTER DATA */

        $departments = Department::pluck('department_name','id');

        $designations = Designation::pluck('designation_name','id');

        return view(
        'attendance.late_entries.index',
        compact('lateEntries','departments','designations')
        );

        }

        public function overtime(Request $request)
        {

        $query = AttendanceRecord::with(['staff','shift']);

        /* ONLY OVERTIME EMPLOYEES */

        $query->where('overtime_minutes','>',0);

        /* FILTER BY DEPARTMENT */

        if($request->department_id){

        $query->where('department_id',$request->department_id);

        }

        /* FILTER BY DESIGNATION */

        if($request->designation_id){

        $query->where('designation_id',$request->designation_id);

        }

        $overtimeRecords = $query->latest()->paginate(10);

        /* LOAD FILTER DATA */

        $departments = Department::pluck('department_name','id');

        $designations = Designation::pluck('designation_name','id');

        return view(
        'attendance.overtime.index',
        compact('overtimeRecords','departments','designations')
        );

        }

        public function dailyReport(Request $request)
        {

        $query = AttendanceRecord::with(['staff','shift']);

        if($request->date){

        $query->whereDate('attendance_date',$request->date);

        }

        if($request->department_id){

        $query->where('department_id',$request->department_id);

        }

        if($request->designation_id){

        $query->where('designation_id',$request->designation_id);

        }

        $records = $query->paginate(10);

        $departments = Department::pluck('department_name','id');
        $designations = Designation::pluck('designation_name','id');

        return view(
        'attendance.reports.daily',
        compact('records','departments','designations')
        );

        }

        public function monthlyReport(Request $request)
            {

            $month = $request->month ?? date('Y-m');

            $records = AttendanceRecord::selectRaw('
            employee_id,
            SUM(status="Present") as present_days,
            SUM(status="Absent") as absent_days,
            SUM(status="Leave") as leave_days,
            SUM(late_minutes > 0) as late_entries,
            SUM(overtime_minutes) as overtime_minutes
            ')
            ->whereMonth('attendance_date',date('m',strtotime($month)))
            ->whereYear('attendance_date',date('Y',strtotime($month)))
            ->groupBy('employee_id')
            ->with('staff')
            ->get();

            $departments = Department::pluck('department_name','id');

            return view(
            'attendance.reports.monthly',
            compact('records','departments','month')
            );

            }
            public function show($id)
{
    $attendance = AttendanceRecord::with(['staff','shift'])
                    ->findOrFail($id);

    return view('attendance.show', compact('attendance'));
}
    public function edit($id)
{
    $attendance = AttendanceRecord::findOrFail($id);

    $departments = Department::pluck('department_name','id');
    $designations = Designation::pluck('designation_name','id');
    $staff = Staff::pluck('name','id');
    $shifts = Shift::pluck('shift_name','id');

    return view('attendance.edit', compact(
        'attendance',
        'departments',
        'designations',
        'staff',
        'shifts'
    ));
}

public function update(Request $request, $id)
{

    $attendance = AttendanceRecord::findOrFail($id);

    $attendance->update([

        'employee_id' => $request->employee_id,
        'department_id' => $request->department_id,
        'designation_id' => $request->designation_id,
        'shift_id' => $request->shift_id,
        'attendance_date' => $request->attendance_date,
        'check_in' => $request->check_in,
        'check_out' => $request->check_out,
        'status' => $request->status

    ]);

    return redirect()
        ->route('hr.attendance.index')
        ->with('success','Attendance updated successfully');

}
}