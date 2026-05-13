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
}