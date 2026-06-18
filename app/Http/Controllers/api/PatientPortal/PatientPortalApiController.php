<?php

namespace App\Http\Controllers\Api\PatientPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\LabReport;
use App\Models\RadiologyReport;

class PatientPortalApiController extends Controller
{public function dashboard()
{
    try {

        // TEMP — fetch all records like web dashboard
        $appointments =
            Appointment::latest()
            ->take(5)
            ->get();

        $labReports =
            LabReport::withoutGlobalScopes()
            ->latest()
            ->take(5)
            ->get();

        $radiologyReports =
            RadiologyReport::withoutGlobalScopes()
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'status' => true,
            'data' => [

                'appointments' => $appointments,

                'lab_reports' => $labReports,

                'radiology_reports' => $radiologyReports,

            ]
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);

    }
} // 🔹 Appointments
// 🔹 Appointments
public function appointments()
{
    try {

        // Load patient relationship
        $appointments = Appointment::with('patient')
            ->latest()
            ->get();

        // Map response
        $data = $appointments->map(function ($a) {

            return [

                'id' => $a->id,

                // ✅ Patient Name
                'patient_name' =>
                    optional($a->patient)->first_name . ' ' .
                    optional($a->patient)->last_name,

                // ✅ Date
                'appointment_date' =>
                    $a->appointment_date,

                // ✅ Time
                'appointment_time' =>
                    $a->appointment_time,

                // ✅ Status
                'status' =>
                    $a->appointment_status,

            ];
        });

        return response()->json([
            'status' => true,
            'data' => $data
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);

    }
}// 🔹 Lab Reports
public function labReports()
{
    try {

        // Load patient relationship
        $reports = LabReport::with('sample.patient')
            ->latest()
            ->get();

        // Format response
        $data = $reports->map(function ($r) {

            return [

                'id' => $r->id,

                // Patient Name
                'patient_name' =>
                    optional(optional($r->sample)->patient)->first_name . ' ' .
                    optional(optional($r->sample)->patient)->last_name,

                // Sample ID
                'sample_id' =>
                    optional($r->sample)->sample_code
                    ?? '-',

                // Status
                'status' =>
                    $r->status
                    ?? '-',

                // Result
                'result' =>
                    $r->result
                    ?? '-',

                // Date
                'report_date' =>
                    $r->created_at
                    ? $r->created_at->format('Y-m-d')
                    : '-',

            ];
        });

        return response()->json([
            'status' => true,
            'data' => $data
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);

    }
}// 🔹 Radiology Reports
public function radiology()
{
    try {

        $reports = RadiologyReport::with(
            'request.patient',
            'request.scanType'
        )
        ->latest()
        ->get();

        $data = $reports->map(function ($r) {

            return [

                'id' => $r->id,

                'patient_name' =>
                    optional(optional($r->request)->patient)->first_name . ' ' .
                    optional(optional($r->request)->patient)->last_name,

                // FIXED
                'scan_type' =>
                    optional(optional($r->request)->scanType)->name
                    ?? optional($r->request)->scan_type
                    ?? '-',

                'status' =>
                    $r->status ?? '-',

                'findings' =>
                    $r->findings ?? '-',

                'report_date' =>
                    $r->created_at
                    ? $r->created_at->format('Y-m-d')
                    : '-',

            ];
        });

        return response()->json([
            'status' => true,
            'data' => $data
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);

    }
}

}