<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DoctorAuditLog;
use App\Models\Patient;
use App\Models\Staff;
use Illuminate\Http\Request;

class DoctorAuditLogController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Audit Logs List
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = DoctorAuditLog::with([
            'patient',
            'doctor'
        ]);

        // Doctor Filter

        if ($request->doctor_id) {

            $query->where(
                'doctor_id',
                $request->doctor_id
            );

        }

        // Patient Filter

        if ($request->patient_id) {

            $query->where(
                'patient_id',
                $request->patient_id
            );

        }

        // Module Filter

        if ($request->module_name) {

            $query->where(
                'module_name',
                $request->module_name
            );

        }

        // Action Filter

        if ($request->action_type) {

            $query->where(
                'action_type',
                $request->action_type
            );

        }

        $logs = $query
            ->latest()
            ->paginate(20);

        $patients = Patient::all();

        $doctors = Staff::all();

        return view(
            'admin.audit.index',
            compact(
                'logs',
                'patients',
                'doctors'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Audit Log Details
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $log = DoctorAuditLog::with([
            'patient',
            'doctor'
        ])->findOrFail($id);

        return view(
            'admin.audit.show',
            compact('log')
        );
    }
}