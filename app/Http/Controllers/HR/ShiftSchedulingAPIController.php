<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\Staff;
use App\Models\ShiftAssignment;
use App\Models\ShiftRotation;
use App\Models\WeeklyOff;
use Carbon\Carbon;

class ShiftSchedulingAPIController extends Controller
{

/* =====================================================
SHIFT MANAGEMENT
=====================================================*/

public function shiftIndex(Request $request)
{
    $query = Shift::query();

    if ($request->search) {
        $query->where('shift_name','like','%'.$request->search.'%');
    }

    $shifts = $query->latest()->get();

    return response()->json([
        'success'=>true,
        'data'=>$shifts
    ]);
}

public function shiftStore(Request $request)
{
    $request->validate([
        'shift_name'=>'required|string|max:100',
        'start_time'=>'required',
        'end_time'=>'required'
    ]);

    $shift = Shift::create([
        'shift_name'=>$request->shift_name,
        'start_time'=>$request->start_time,
        'end_time'=>$request->end_time,
        'grace_minutes'=>$request->grace_minutes,
        'break_minutes'=>$request->break_minutes,
        'remarks'=>$request->remarks,
        'status'=>$request->status ?? 1
    ]);

    return response()->json([
        'success'=>true,
        'message'=>'Shift created successfully',
        'data'=>$shift
    ]);
}

public function shiftShow($id)
{
    $shift = Shift::findOrFail($id);

    return response()->json([
        'success'=>true,
        'data'=>$shift
    ]);
}

public function shiftUpdate(Request $request,$id)
{
    $shift = Shift::findOrFail($id);

    $shift->update([
        'shift_name'=>$request->shift_name,
        'start_time'=>$request->start_time,
        'end_time'=>$request->end_time,
        'grace_minutes'=>$request->grace_minutes,
        'break_minutes'=>$request->break_minutes,
        'remarks'=>$request->remarks,
        'status'=>$request->status ?? 1
    ]);

    return response()->json([
        'success'=>true,
        'message'=>'Shift updated successfully',
        'data'=>$shift
    ]);
}

public function shiftDelete($id)
{
    Shift::findOrFail($id)->delete();

    return response()->json([
        'success'=>true,
        'message'=>'Shift moved to trash'
    ]);
}

public function toggleShiftStatus($id)
{
    $shift = Shift::findOrFail($id);

    $shift->status = !$shift->status;
    $shift->save();

    return response()->json([
        'success'=>true,
        'status'=>$shift->status
    ]);
}

public function deletedShifts()
{
    $shifts = Shift::onlyTrashed()->get();

    return response()->json([
        'success'=>true,
        'data'=>$shifts
    ]);
}

public function restoreShift($id)
{
    Shift::withTrashed()->findOrFail($id)->restore();

    return response()->json([
        'success'=>true,
        'message'=>'Shift restored'
    ]);
}

public function forceDeleteShift($id)
{
    Shift::withTrashed()->findOrFail($id)->forceDelete();

    return response()->json([
        'success'=>true,
        'message'=>'Shift permanently deleted'
    ]);
}


/* =====================================================
SHIFT ASSIGNMENT
=====================================================*/

public function assignmentIndex()
{
    $assignments = ShiftAssignment::with(['staff','shift'])->paginate(10);

    return response()->json([
        'success'=>true,
        'data'=>$assignments
    ]);
}

public function assignmentStore(Request $request)
{
    $request->validate([
        'staff_id'=>'required',
        'shift_id'=>'required',
        'start_date'=>'required|date'
    ]);

    $assignment = ShiftAssignment::create($request->all());

    return response()->json([
        'success'=>true,
        'message'=>'Shift assigned successfully',
        'data'=>$assignment
    ]);
}

public function assignmentShow($id)
{
    $assignment = ShiftAssignment::with(['staff','shift'])->findOrFail($id);

    return response()->json([
        'success'=>true,
        'data'=>$assignment
    ]);
}

public function assignmentDelete($id)
{
    ShiftAssignment::findOrFail($id)->delete();

    return response()->json([
        'success'=>true,
        'message'=>'Assignment moved to trash'
    ]);
}

public function deletedAssignments()
{
    $assignments = ShiftAssignment::onlyTrashed()->paginate(10);

    return response()->json([
        'success'=>true,
        'data'=>$assignments
    ]);
}

public function restoreAssignment($id)
{
    ShiftAssignment::withTrashed()->findOrFail($id)->restore();

    return response()->json([
        'success'=>true,
        'message'=>'Assignment restored'
    ]);
}

public function forceDeleteAssignment($id)
{
    ShiftAssignment::withTrashed()->findOrFail($id)->forceDelete();

    return response()->json([
        'success'=>true,
        'message'=>'Assignment permanently deleted'
    ]);
}


/* =====================================================
SHIFT ROTATION
=====================================================*/

public function rotationIndex()
{
    $rotations = ShiftRotation::with(['staff','firstShift','secondShift'])->paginate(10);

    return response()->json([
        'success'=>true,
        'data'=>$rotations
    ]);
}

public function rotationStore(Request $request)
{
    $request->validate([
        'staff_id'=>'required',
        'first_shift_id'=>'required',
        'second_shift_id'=>'required',
        'rotation_days'=>'required|numeric',
        'start_date'=>'required|date'
    ]);

    $rotation = ShiftRotation::create($request->all());

    return response()->json([
        'success'=>true,
        'message'=>'Rotation created successfully',
        'data'=>$rotation
    ]);
}

public function rotationShow($id)
{
    $rotation = ShiftRotation::with(['staff','firstShift','secondShift'])->findOrFail($id);

    return response()->json([
        'success'=>true,
        'data'=>$rotation
    ]);
}

public function rotationUpdate(Request $request,$id)
{
    $rotation = ShiftRotation::findOrFail($id);

    $rotation->update($request->all());

    return response()->json([
        'success'=>true,
        'message'=>'Rotation updated',
        'data'=>$rotation
    ]);
}

public function rotationDelete($id)
{
    ShiftRotation::findOrFail($id)->delete();

    return response()->json([
        'success'=>true,
        'message'=>'Rotation moved to trash'
    ]);
}

public function deletedRotations()
{
    $rotations = ShiftRotation::onlyTrashed()->paginate(10);

    return response()->json([
        'success'=>true,
        'data'=>$rotations
    ]);
}

public function restoreRotation($id)
{
    ShiftRotation::withTrashed()->findOrFail($id)->restore();

    return response()->json([
        'success'=>true,
        'message'=>'Rotation restored'
    ]);
}

public function forceDeleteRotation($id)
{
    ShiftRotation::withTrashed()->findOrFail($id)->forceDelete();

    return response()->json([
        'success'=>true,
        'message'=>'Rotation permanently deleted'
    ]);
}


/* =====================================================
WEEKLY OFF
=====================================================*/

public function weeklyOffIndex()
{
    $weeklyOffs = WeeklyOff::with('staff')->latest()->paginate(10);

    return response()->json([
        'success'=>true,
        'data'=>$weeklyOffs
    ]);
}

public function weeklyOffStore(Request $request)
{
    $request->validate([
        'staff_id'=>'required',
        'week_day'=>'required'
    ]);

    $weeklyOff = WeeklyOff::create([
        'staff_id'=>$request->staff_id,
        'week_day'=>$request->week_day,
        'status'=>$request->status ?? 1
    ]);

    return response()->json([
        'success'=>true,
        'message'=>'Weekly off added',
        'data'=>$weeklyOff
    ]);
}

public function weeklyOffShow($id)
{
    $weeklyOff = WeeklyOff::with('staff')->findOrFail($id);

    return response()->json([
        'success'=>true,
        'data'=>$weeklyOff
    ]);
}

public function weeklyOffUpdate(Request $request,$id)
{
    $weeklyOff = WeeklyOff::findOrFail($id);

    $weeklyOff->update([
        'staff_id'=>$request->staff_id,
        'week_day'=>$request->week_day,
        'status'=>$request->status
    ]);

    return response()->json([
        'success'=>true,
        'message'=>'Weekly off updated',
        'data'=>$weeklyOff
    ]);
}

public function weeklyOffDelete($id)
{
    WeeklyOff::findOrFail($id)->delete();

    return response()->json([
        'success'=>true,
        'message'=>'Weekly off moved to trash'
    ]);
}

public function deletedWeeklyOffs()
{
    $weeklyOffs = WeeklyOff::onlyTrashed()->paginate(10);

    return response()->json([
        'success'=>true,
        'data'=>$weeklyOffs
    ]);
}

public function restoreWeeklyOff($id)
{
    WeeklyOff::withTrashed()->findOrFail($id)->restore();

    return response()->json([
        'success'=>true,
        'message'=>'Weekly off restored'
    ]);
}

public function forceDeleteWeeklyOff($id)
{
    WeeklyOff::withTrashed()->findOrFail($id)->forceDelete();

    return response()->json([
        'success'=>true,
        'message'=>'Weekly off permanently deleted'
    ]);
}


/* =====================================================
SHIFT CONFLICT DETECTION
=====================================================*/

public function conflictIndex()
{
    $conflicts = [];

    $assignments = ShiftAssignment::with(['staff','shift'])->get();

    foreach($assignments as $assignment){

        $staffId = $assignment->staff_id;
        $date = $assignment->start_date;

        $day = date('l',strtotime($date));

        /* WEEKLY OFF CONFLICT */

        $weeklyOff = WeeklyOff::where('staff_id',$staffId)
                    ->where('week_day',$day)
                    ->exists();

        if($weeklyOff){
            $conflicts[] = [
                'employee'=>$assignment->staff->name,
                'date'=>$date,
                'shift'=>$assignment->shift->shift_name,
                'type'=>'Weekly Off Conflict'
            ];
        }

        /* DOUBLE SHIFT */

        $doubleShift = ShiftAssignment::where('staff_id',$staffId)
                        ->whereDate('start_date',$date)
                        ->count();

        if($doubleShift > 1){
            $conflicts[] = [
                'employee'=>$assignment->staff->name,
                'date'=>$date,
                'shift'=>$assignment->shift->shift_name,
                'type'=>'Double Shift Conflict'
            ];
        }

        /* ROTATION CONFLICT */

        $rotation = ShiftRotation::where('staff_id',$staffId)->first();

        if($rotation){

            $days = Carbon::parse($rotation->start_date)->diffInDays($date);

            $cycle = floor($days / $rotation->rotation_days);

            $expectedShift = $cycle % 2 == 0
                ? $rotation->first_shift_id
                : $rotation->second_shift_id;

            if($expectedShift != $assignment->shift_id){

                $conflicts[] = [
                    'employee'=>$assignment->staff->name,
                    'date'=>$date,
                    'shift'=>$assignment->shift->shift_name,
                    'type'=>'Rotation Conflict'
                ];
            }
        }

    }

    return response()->json([
        'success'=>true,
        'data'=>$conflicts
    ]);
}

}