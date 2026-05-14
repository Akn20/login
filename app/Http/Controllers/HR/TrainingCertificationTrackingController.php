<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\TrainingCertificationTracking;

use App\Models\Staff;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Auth;

class TrainingCertificationTrackingController extends Controller
{
    /**
     * INDEX
     */
    public function index()
    {
        $records = TrainingCertificationTracking::latest()
            ->paginate(10);

        return view(
            'hr.trainingCertificationTracking.index',
            compact('records')
        );
    }

    /**
     * CREATE
     */
    public function create()
    {
        $employees = Staff::orderBy('name')
            ->get();

        return view(
            'hr.trainingCertificationTracking.create',
            compact('employees')
        );
    }

    /**
     * STORE
     */
    public function store(Request $request)
    {
        $request->validate([

            'employee_id' => 'required',

            'training_name' => 'required',

            'training_code' => 'required|unique:training_certification_trackings,training_code',

            'issue_date' => 'required',

            'expiry_date' => 'required',
            'attachment' =>
    'nullable|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $employee = Staff::where(
            'employee_id',
            $request->employee_id
        )->first();

        // AUTO STATUS
        $status = 'Active';

        if (
            now()->gt($request->expiry_date)
        ) {
            $status = 'Expired';
        }


        $attachmentPath = null;

if ($request->hasFile('attachment')) {

    $attachmentPath = $request
        ->file('attachment')
        ->store(
            'training-certifications',
            'public'
        );
}
        TrainingCertificationTracking::create([

            'id' => Str::uuid(),

            // Employee
            'employee_id' => $request->employee_id,

            'employee_name' => $employee->name ?? null,

            'department' =>
                optional($employee->department)->department_name,

            'designation' =>
                optional($employee->designation)->designation_name,

            // Training
            'training_code' => $request->training_code,

            'training_name' => $request->training_name,

            'training_type' => $request->training_type,

            'training_provider' =>
                $request->training_provider,

            'training_location' =>
                $request->training_location,

            'training_start_date' =>
                $request->training_start_date,

            'training_end_date' =>
                $request->training_end_date,

            // Certification
            'certification_name' =>
                $request->certification_name,

            'certification_number' =>
                $request->certification_number,

            'issue_date' =>
                $request->issue_date,

            'expiry_date' =>
                $request->expiry_date,

            'certification_authority' =>
                $request->certification_authority,

            // Renewal
            'renewal_required' =>
                $request->renewal_required ?? 0,

            // Status
            'status' => $status,

            // Reminder
            'reminder_days' =>
                $request->reminder_days,

            'reminder_enabled' =>
                $request->reminder_enabled ?? 0,

            // Additional
            'remarks' =>
                $request->remarks,
            'attachment' => $attachmentPath,

            'created_by' =>
                Auth::id(),
        ]);

        return redirect()
            ->route(
                'hr.training-certification-tracking.index'
            )
            ->with(
                'success',
                'Training record created successfully.'
            );
    }
// ================= API INDEX =================
public function formData()
{
    $employees = Staff::with([
        'department',
        'designation'
    ])->get();

    return response()->json([
        'employees' => $employees
    ]);
}
public function employees()
{
    $employees = Staff::with([
        'department:id,department_name',
        'designation:id,designation_name'
    ])
    ->select(
        'id',
        'employee_id',
        'name',
        'department_id',
        'designation_id'
    )
    ->get();

    return response()->json($employees);
}
public function apiIndex()
{
    $records = TrainingCertificationTracking::latest()
        ->get();

    return response()->json($records);
}


// ================= SHOW =================
public function apiShow($id)
{
    $record = TrainingCertificationTracking::findOrFail($id);

    return response()->json($record);
}

// ================= STORE =================
public function apiStore(Request $request)
{
    $employee = Staff::where(
        'employee_id',
        $request->employee_id
    )->first();

    $status = 'Active';

    if (now()->gt($request->expiry_date)) {
        $status = 'Expired';
    }

    $record = TrainingCertificationTracking::create([

        'id' => Str::uuid(),

        'employee_id' => $request->employee_id,

        'employee_name' => $employee->name ?? null,

        'department' =>
            optional($employee->department)->department_name,

        'designation' =>
            optional($employee->designation)->designation_name,

        'training_code' => $request->training_code,

        'training_name' => $request->training_name,

        'training_type' => $request->training_type,

        'training_provider' =>
            $request->training_provider,

        'training_location' =>
            $request->training_location,

        'training_start_date' =>
            $request->training_start_date,

        'training_end_date' =>
            $request->training_end_date,

        'certification_name' =>
            $request->certification_name,

        'certification_number' =>
            $request->certification_number,

        'issue_date' =>
            $request->issue_date,

        'expiry_date' =>
            $request->expiry_date,

        'certification_authority' =>
            $request->certification_authority,

        'renewal_required' =>
            $request->renewal_required ?? 0,

        'status' => $status,

        'reminder_days' =>
            $request->reminder_days,

        'reminder_enabled' =>
            $request->reminder_enabled ?? 0,

        'remarks' =>
            $request->remarks,

        'created_by' =>
            Auth::id(),
    ]);

    return response()->json([
        'message' => 'Created Successfully',
        'data' => $record
    ]);
}

// ================= UPDATE =================
public function apiUpdate(Request $request, $id)
{
    $record = TrainingCertificationTracking::findOrFail($id);

    $employee = Staff::where(
        'employee_id',
        $request->employee_id
    )->first();

    $status = 'Active';

    if (now()->gt($request->expiry_date)) {
        $status = 'Expired';
    }

    $record->update([

        'employee_id' => $request->employee_id,

        'employee_name' => $employee->name ?? null,

        'department' =>
            optional($employee->department)->department_name,

        'designation' =>
            optional($employee->designation)->designation_name,

        'training_code' => $request->training_code,

        'training_name' => $request->training_name,

        'training_type' => $request->training_type,

        'training_provider' =>
            $request->training_provider,

        'training_location' =>
            $request->training_location,

        'training_start_date' =>
            $request->training_start_date,

        'training_end_date' =>
            $request->training_end_date,

        'certification_name' =>
            $request->certification_name,

        'certification_number' =>
            $request->certification_number,

        'issue_date' =>
            $request->issue_date,

        'expiry_date' =>
            $request->expiry_date,

        'certification_authority' =>
            $request->certification_authority,

        'renewal_required' =>
            $request->renewal_required ?? 0,

        'status' => $status,

        'reminder_days' =>
            $request->reminder_days,

        'reminder_enabled' =>
            $request->reminder_enabled ?? 0,

        'remarks' =>
            $request->remarks,

        'updated_by' =>
            Auth::id(),
    ]);

    return response()->json([
        'message' => 'Updated Successfully',
        'data' => $record
    ]);
}

// ================= DELETE =================
public function apiDelete($id)
{
    TrainingCertificationTracking::findOrFail($id)
        ->delete();

    return response()->json([
        'message' => 'Deleted Successfully'
    ]);
}

// ================= DELETED =================
public function deleted()
{
    return response()->json(
        TrainingCertificationTracking::onlyTrashed()
            ->latest()
            ->get()
    );
}

// ================= RESTORE =================
public function restore($id)
{
    TrainingCertificationTracking::onlyTrashed()
        ->findOrFail($id)
        ->restore();

    return response()->json([
        'message' => 'Restored Successfully'
    ]);
}

// ================= FORCE DELETE =================
public function forceDelete($id)
{
    TrainingCertificationTracking::onlyTrashed()
        ->findOrFail($id)
        ->forceDelete();

    return response()->json([
        'message' => 'Deleted Permanently'
    ]);
}
}