<?php

namespace App\Http\Controllers\doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FollowUp;
use App\Models\Patient;
use App\Models\Staff;
use App\Models\Notification;
use App\Models\Consultation;

class FollowUpController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {

        $query = FollowUp::with([
            'patient',
            'doctor',
            'consultation'
        ]);

        // SEARCH PATIENT

        if ($request->patient_name) {

            $query->whereHas('patient', function ($q) use ($request) {

                $q->where(
                    'first_name',
                    'like',
                    '%' . $request->patient_name . '%'
                )

                ->orWhere(
                    'last_name',
                    'like',
                    '%' . $request->patient_name . '%'
                );

            });
        }

        // STATUS FILTER

        if ($request->status) {

            $query->where(
                'status',
                $request->status
            );
        }

        // DATE FILTERS

        if ($request->from_date) {

            $query->whereDate(
                'follow_up_date',
                '>=',
                $request->from_date
            );
        }

        if ($request->to_date) {

            $query->whereDate(
                'follow_up_date',
                '<=',
                $request->to_date
            );
        }

        $followUps = $query
            ->latest()
            ->paginate(10);

        return view(
            'doctor.followups.index',
            compact('followUps')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {

        $patients = Patient::all();

        $doctors = Staff::all();

            $consultations = Consultation::with('patient')->latest()->get();

        return view(
            'doctor.followups.create',
            compact(
                'patients',
                'doctors',
                'consultations'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {

        $request->validate([

            'patient_id' => 'required',

            'doctor_id' => 'required',

            'consultation_id' => 'required',

            'follow_up_date' => 'required|date',

            'status' => 'required'

        ]);

        $followup = FollowUp::create([

            'patient_id' => $request->patient_id,

            'doctor_id' => $request->doctor_id,

            'consultation_id' => $request->consultation_id,

            'follow_up_date' => $request->follow_up_date,

            'status' => $request->status,

            'remarks' => $request->remarks

        ]);

        /*
        |--------------------------------------------------------------------------
        | CREATE NOTIFICATION
        |--------------------------------------------------------------------------
        */

        $patient = Patient::find($request->patient_id);

        Notification::create([

            'user_id' => $request->doctor_id,

            'patient_id' => $request->patient_id,

            'type' => 'Follow-up',

            'title' => 'Follow-up Scheduled',

            'message' =>
                'Follow-up scheduled for patient '
                . $patient->first_name . ' '
                . $patient->last_name
                . ' on '
                . date(
                    'd M Y',
                    strtotime($request->follow_up_date)
                ),

            'priority' => 'Medium',

            'reference_id' => $followup->id,

            'is_read' => false

        ]);

        return redirect()
            ->route('doctor.followups.index')
            ->with(
                'success',
                'Follow-up created successfully'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {

        $followup = FollowUp::with([
            'patient',
            'doctor',
            'consultation'
        ])->findOrFail($id);

        return view(
            'doctor.followups.show',
            compact('followup')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {

        $followup = FollowUp::findOrFail($id);

        return view(
            'doctor.followups.edit',
            compact('followup')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {

        $followup = FollowUp::findOrFail($id);

        $followup->update([

            'follow_up_date' => $request->follow_up_date,

            'status' => $request->status,

            'remarks' => $request->remarks

        ]);

        return redirect()
            ->route('doctor.followups.index')
            ->with(
                'success',
                'Follow-up updated successfully'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {

        $followup = FollowUp::findOrFail($id);

        $followup->delete();

        return redirect()
            ->route('doctor.followups.index')
            ->with(
                'success',
                'Follow-up deleted successfully'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | MARK COMPLETED
    |--------------------------------------------------------------------------
    */

    public function markCompleted($id)
    {

        $followup = FollowUp::findOrFail($id);

        $followup->update([

            'status' => 'Completed'

        ]);

        return back()->with(
            'success',
            'Follow-up marked as completed'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MARK MISSED
    |--------------------------------------------------------------------------
    */

    public function markMissed($id)
    {

        $followup = FollowUp::findOrFail($id);

        $followup->update([

            'status' => 'Missed'

        ]);

        return back()->with(
            'success',
            'Follow-up marked as missed'
        );
    }

    public function deleted()
    {

        $followUps = FollowUp::onlyTrashed()->with([
            'patient',
            'doctor',
            'consultation'
        ])->latest()->get();

        return view(
            'doctor.followups.deleted',
            compact('followUps')
        );
    }

    public function restore($id)
    {

        $followup = FollowUp::withTrashed()->findOrFail($id);

        $followup->restore();

        return back()->with(
            'success',
            'Follow-up restored successfully'
        );
    }

    public function forceDelete($id)
    {

        $followup = FollowUp::withTrashed()->findOrFail($id);

        $followup->forceDelete();

        return back()->with(
            'success',
            'Follow-up permanently deleted'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | API INDEX
    |--------------------------------------------------------------------------
    */

    public function apiIndex()
    {

        $followUps = FollowUp::with([
            'patient',
            'doctor',
            'consultation'
        ])->latest()->get();

        return response()->json([

            'status' => true,

            'data' => $followUps

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | API STORE
    |--------------------------------------------------------------------------
    */

   public function apiStore(Request $request)
{
    $request->validate([

        'patient_id' =>
            'required|exists:patients,id',

        'doctor_id' =>
            'required|exists:staff,id',

        'consultation_id' =>
            'required|exists:consultations,id',

        'follow_up_date' =>
            'required|date',

        'status' =>
            'required'
    ]);

    $followup = FollowUp::create([

        'patient_id' =>
            $request->patient_id,

        'doctor_id' =>
            $request->doctor_id,

        'consultation_id' =>
            $request->consultation_id,

        'follow_up_date' =>
            $request->follow_up_date,

        'status' =>
            $request->status,

        'remarks' =>
            $request->remarks
    ]);

    return response()->json([

        'status' => true,

        'message' =>
            'Follow-up created successfully',

        'data' => $followup

    ]);
}

    /*
    |--------------------------------------------------------------------------
    | API UPDATE
    |--------------------------------------------------------------------------
    */

    public function apiUpdate(Request $request, $id)
{
    $followup = FollowUp::findOrFail($id);

    $request->validate([

        'follow_up_date' =>
            'required|date',

        'status' =>
            'required'
    ]);

    $followup->update([

        'follow_up_date' =>
            $request->follow_up_date,

        'status' =>
            $request->status,

        'remarks' =>
            $request->remarks
    ]);

    return response()->json([

        'status' => true,

        'message' =>
            'Follow-up updated successfully',

        'data' => $followup

    ]);
}

    /*
    |--------------------------------------------------------------------------
    | API DELETE
    |--------------------------------------------------------------------------
    */

    public function apiDelete($id)
    {

        $followup = FollowUp::findOrFail($id);

        $followup->delete();

        return response()->json([

            'status' => true,

            'message' => 'Follow-up deleted successfully'

        ]);
    }

    public function apiShow($id)
{
    $followup = FollowUp::with([
        'patient',
        'doctor',
        'consultation'
    ])->findOrFail($id);

    return response()->json([

        'status' => true,

        'data' => $followup

    ]);
}
public function apiDeleted()
{
    $followUps = FollowUp::onlyTrashed()
        ->with([
            'patient',
            'doctor',
            'consultation'
        ])
        ->latest()
        ->get();

    return response()->json([

        'status' => true,

        'data' => $followUps

    ]);
}
public function apiRestore($id)
{
    $followup = FollowUp::withTrashed()
        ->findOrFail($id);

    $followup->restore();

    return response()->json([

        'status' => true,

        'message' =>
            'Follow-up restored successfully'

    ]);
}
public function apiForceDelete($id)
{
    $followup = FollowUp::withTrashed()
        ->findOrFail($id);

    $followup->forceDelete();

    return response()->json([

        'status' => true,

        'message' =>
            'Follow-up permanently deleted'

    ]);
}
public function apiMarkCompleted($id)
{
    $followup = FollowUp::findOrFail($id);

    $followup->update([

        'status' => 'Completed'

    ]);

    return response()->json([

        'status' => true,

        'message' =>
            'Follow-up marked as completed'

    ]);
}

public function apiMarkMissed($id)
{
    $followup = FollowUp::findOrFail($id);

    $followup->update([

        'status' => 'Missed'

    ]);

    return response()->json([

        'status' => true,

        'message' =>
            'Follow-up marked as missed'

    ]);
}

public function apiSearch(Request $request)
{
    $query = FollowUp::with([
        'patient',
        'doctor',
        'consultation'
    ]);

    // Patient search
    if ($request->patient_name) {

        $query->whereHas(
            'patient',
            function ($q) use ($request) {

                $q->where(
                    'first_name',
                    'like',
                    '%' . $request->patient_name . '%'
                )
                ->orWhere(
                    'last_name',
                    'like',
                    '%' . $request->patient_name . '%'
                );
            }
        );
    }

    // Status filter
    if ($request->status) {

        $query->where(
            'status',
            $request->status
        );
    }

    // From date
    if ($request->from_date) {

        $query->whereDate(
            'follow_up_date',
            '>=',
            $request->from_date
        );
    }

    // To date
    if ($request->to_date) {

        $query->whereDate(
            'follow_up_date',
            '<=',
            $request->to_date
        );
    }

    $followUps = $query
        ->latest()
        ->get();

    return response()->json([

        'status' => true,

        'data' => $followUps

    ]);
}

}

