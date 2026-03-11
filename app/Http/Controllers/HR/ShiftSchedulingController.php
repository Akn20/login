<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\Staff;
use App\Models\ShiftAssignment;
use App\Models\ShiftRotation;
use App\Models\WeeklyOff;

class ShiftSchedulingController extends Controller
{

    /* =========================
       SHIFT LIST
    ========================= */

    public function shiftIndex(Request $request)
    {
        $query = Shift::query();

        if ($request->search) {
            $query->where('shift_name', 'like', '%' . $request->search . '%');
        }

        $shifts = $query->latest()->paginate(10);

        return view(
            'hr.shift_scheduling.shift_management.index',
            compact('shifts')
        );
    }


    /* =========================
       CREATE SHIFT PAGE
    ========================= */

    public function shiftCreate()
    {
        return view(
            'hr.shift_scheduling.shift_management.create'
        );
    }


    /* =========================
       STORE SHIFT
    ========================= */

    public function shiftStore(Request $request)
    {
        $request->validate([
            'shift_name' => 'required|string|max:100',
            'start_time' => 'required',
            'end_time'   => 'required',
        ]);

        Shift::create([
            'shift_name'     => $request->shift_name,
            'start_time'     => $request->start_time,
            'end_time'       => $request->end_time,
            'grace_minutes'  => $request->grace_minutes,
            'break_minutes'  => $request->break_minutes,
            'remarks'        => $request->remarks,
            'status'         => $request->status ?? 1,
        ]);

        return redirect()
            ->route('admin.shifts.index')
            ->with('success', 'Shift created successfully');
    }


    /* =========================
       EDIT SHIFT
    ========================= */

    public function shiftEdit($id)
    {
        $shift = Shift::findOrFail($id);

        return view(
            'hr.shift_scheduling.shift_management.edit',
            compact('shift')
        );
    }


    /* =========================
       UPDATE SHIFT
    ========================= */

    public function shiftUpdate(Request $request, $id)
    {
        $request->validate([
            'shift_name' => 'required|string|max:100',
            'start_time' => 'required',
            'end_time'   => 'required',
        ]);

        $shift = Shift::findOrFail($id);

        $shift->update([
            'shift_name'     => $request->shift_name,
            'start_time'     => $request->start_time,
            'end_time'       => $request->end_time,
            'grace_minutes'  => $request->grace_minutes,
            'break_minutes'  => $request->break_minutes,
            'remarks'        => $request->remarks,
            'status'         => $request->status ?? 1,
        ]);

        return redirect()
            ->route('admin.shifts.index')
            ->with('success', 'Shift updated successfully');
    }


    /* =========================
       DELETE SHIFT
    ========================= */

    public function shiftDelete($id)
    {
        $shift = Shift::findOrFail($id);

        $shift->delete();

        return redirect()
            ->route('admin.shifts.index')
            ->with('success', 'Shift moved to trash');
    }

    public function toggleShiftStatus($id)
{
    $shift = Shift::findOrFail($id);

    $shift->status = !$shift->status;
    $shift->save();

    return response()->json([
        'success' => true,
        'status' => $shift->status
    ]);
}

public function deletedShifts()
{
    $shifts = Shift::onlyTrashed()->get();

    return view(
        'hr.shift_scheduling.shift_management.deleted',
        compact('shifts')
    );
}


public function restoreShift($id)
{
    Shift::withTrashed()->findOrFail($id)->restore();

    return redirect()
        ->route('admin.shifts.deleted')
        ->with('success','Shift restored');
}


public function forceDeleteShift($id)
{
    Shift::withTrashed()->findOrFail($id)->forceDelete();

    return redirect()
        ->route('admin.shifts.deleted')
        ->with('success','Shift permanently deleted');
}

public function shiftShow($id)
{
    $shift = Shift::findOrFail($id);

    return view(
        'hr.shift_scheduling.shift_management.show',
        compact('shift')
    );
}

    public function assignmentIndex()
{
    $assignments = ShiftAssignment::with(['staff','shift'])->paginate(10);

    return view(
        'hr.shift_scheduling.shift_assignment.index',
        compact('assignments')
    );
}

public function assignmentCreate()
{
    $staff = Staff::pluck('name','id');
    $shifts = Shift::pluck('shift_name','id');

    return view(
        'hr.shift_scheduling.shift_assignment.create',
        compact('staff','shifts')
    );
}

public function assignmentStore(Request $request)
{
    $request->validate([
        'staff_id' => 'required',
        'shift_id' => 'required',
        'start_date' => 'required|date'
    ]);

    ShiftAssignment::create($request->all());

    return redirect()
        ->route('admin.shift-assignments.index')
        ->with('success','Shift assigned successfully');
}


public function rotationIndex()
{
    $rotations = ShiftRotation::with(['staff','firstShift','secondShift'])
                ->paginate(10);

    return view(
        'hr.shift_scheduling.shift_rotation.index',
        compact('rotations')
    );
}


public function rotationCreate()
{
    $staff = Staff::pluck('name','id');
    $shifts = Shift::pluck('shift_name','id');

    return view(
        'hr.shift_scheduling.shift_rotation.create',
        compact('staff','shifts')
    );
}


public function rotationStore(Request $request)
{
    $request->validate([
        'staff_id' => 'required',
        'first_shift_id' => 'required',
        'second_shift_id' => 'required',
        'rotation_days' => 'required|numeric',
        'start_date' => 'required|date'
    ]);

    ShiftRotation::create($request->all());

    return redirect()
        ->route('admin.shift-rotations.index')
        ->with('success','Rotation created successfully');
}


public function rotationEdit($id)
{
    $rotation = ShiftRotation::findOrFail($id);

    $staff = Staff::pluck('name','id');
    $shifts = Shift::pluck('shift_name','id');

    return view(
        'hr.shift_scheduling.shift_rotation.edit',
        compact('rotation','staff','shifts')
    );
}


public function rotationUpdate(Request $request,$id)
{
    $rotation = ShiftRotation::findOrFail($id);

    $rotation->update($request->all());

    return redirect()
        ->route('admin.shift-rotations.index')
        ->with('success','Rotation updated');
}

public function weeklyOffIndex()
{
    $weeklyOffs = WeeklyOff::with('staff')
                    ->latest()
                    ->paginate(10);

    return view(
        'hr.shift_scheduling.weekly_off.index',
        compact('weeklyOffs')
    );
}


public function weeklyOffCreate()
{
    $staff = Staff::pluck('name','id');

    return view(
        'hr.shift_scheduling.weekly_off.create',
        compact('staff')
    );
}

public function weeklyOffStore(Request $request)
{
    $request->validate([
        'staff_id' => 'required',
        'week_day' => 'required'
    ]);

    WeeklyOff::create([
        'staff_id' => $request->staff_id,
        'week_day' => $request->week_day,
        'status' => $request->status ?? 1
    ]);

    return redirect()
        ->route('admin.weekly-offs.index')
        ->with('success','Weekly Off Added Successfully');
}

public function weeklyOffEdit($id)
{
    $weeklyOff = WeeklyOff::findOrFail($id);

    $staff = Staff::pluck('name','id');

    return view(
        'hr.shift_scheduling.weekly_off.edit',
        compact('weeklyOff','staff')
    );
}

public function weeklyOffUpdate(Request $request,$id)
{

    $weeklyOff = WeeklyOff::findOrFail($id);

    $weeklyOff->update([
        'staff_id' => $request->staff_id,
        'week_day' => $request->week_day,
        'status' => $request->status
    ]);

    return redirect()
        ->route('admin.weekly-offs.index')
        ->with('success','Weekly Off Updated');
}

public function conflictIndex()
{
    $conflicts = [];

    $assignments = ShiftAssignment::with(['staff','shift'])->get();

    foreach($assignments as $assignment){

        $staffId = $assignment->staff_id;
        $date = $assignment->start_date;

        $day = date('l', strtotime($date));

        /* WEEKLY OFF CONFLICT */

        $weeklyOff = WeeklyOff::where('staff_id',$staffId)
                    ->where('week_day',$day)
                    ->exists();

        if($weeklyOff){

            $conflicts[] = [
                'employee' => $assignment->staff->name,
                'date' => $date,
                'shift' => $assignment->shift->shift_name,
                'type' => 'Weekly Off Conflict'
            ];
        }

        /* DOUBLE SHIFT CONFLICT */

        $doubleShift = ShiftAssignment::where('staff_id',$staffId)
                        ->whereDate('start_date',$date)
                        ->count();

        if($doubleShift > 1){

            $conflicts[] = [
                'employee' => $assignment->staff->name,
                'date' => $date,
                'shift' => $assignment->shift->shift_name,
                'type' => 'Double Shift Conflict'
            ];
        }

        /* ROTATION CONFLICT */

        $rotation = ShiftRotation::where('staff_id',$staffId)->first();

        if($rotation){

            $days = \Carbon\Carbon::parse($rotation->start_date)
                    ->diffInDays($date);

            $cycle = floor($days / $rotation->rotation_days);

            $expectedShift = $cycle % 2 == 0
                ? $rotation->first_shift_id
                : $rotation->second_shift_id;

            if($expectedShift != $assignment->shift_id){

                $conflicts[] = [
                    'employee' => $assignment->staff->name,
                    'date' => $date,
                    'shift' => $assignment->shift->shift_name,
                    'type' => 'Rotation Conflict'
                ];
            }

        }

    }

    return view(
        'hr.shift_scheduling.shift_conflicts.index',
        compact('conflicts')
    );
}

}