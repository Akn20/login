<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\LabRequest;
use App\Models\LabTest;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Roles;
use App\Models\SampleCollection;
use App\Models\Staff;
use App\Models\ClinicalNote;
use App\Models\LabReport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;


class LabRequestController extends Controller
{

    public function index(Request $request)
    {
        $query = LabRequest::with([
            'patient',
            'sample',
        ]);

        // SEARCH
        if ($request->search) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                // Patient Name
                $q->whereHas('patient', function ($patient) use ($search) {

                    $patient->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");

                })

                    // Test Name
                    ->orWhere('test_name', 'like', "%{$search}%");

            });
        }

        $requests = $query->latest()->get();

        return view(
            'doctor.laboratory.laboratory-requests',
            compact('requests')
        );
    }

    public function completedReports(Request $request)
    {
        $query = LabReport::with([
            'sample.labRequest.patient'
        ])
            ->where('status', 'Completed');

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->search) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                // Search patient name
                $q->whereHas('sample.labRequest.patient', function ($patient) use ($search) {

                    $patient->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");

                })

                    // Search test name
                    ->orWhereHas('sample.labRequest', function ($lab) use ($search) {

                        $lab->where('test_name', 'like', "%{$search}%");

                    });

            });
        }

        $reports = $query->latest()->get();

        return view(
            'doctor.laboratory.laboratory-reports',
            compact('reports')
        );
    }

    public function historicalReports(Request $request)
    {
        $query = LabReport::with([
            'sample.labRequest.patient'
        ])
            ->where('status', 'Completed');

        // SEARCH
        if ($request->search) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                // Search patient name
                $q->whereHas('sample.labRequest.patient', function ($patient) use ($search) {

                    $patient->where('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%");

                })

                    // Search test name
                    ->orWhereHas('sample.labRequest', function ($lab) use ($search) {

                        $lab->where('test_name', 'like', "%$search%");

                    });

            });

        }

        // DATE FILTER
        if ($request->from_date) {

            $query->whereDate('created_at', '>=', $request->from_date);

        }

        if ($request->to_date) {

            $query->whereDate('created_at', '<=', $request->to_date);

        }

        $reports = $query->latest()->get();

        /*
        |--------------------------------------------------------------------------
        | STATUS FILTER
        |--------------------------------------------------------------------------
        */

        if (
            $request->verification_status &&
            $request->verification_status != 'All'
        ) {

            $query->where(
                'verification_status',
                $request->verification_status
            );
        }

        $reports = $query->latest()->get();

        return view(
            'doctor.laboratory.historical-reports',
            compact('reports')
        );
    }

    public function compareReports($patientId, $testName)
    {
        $reports = LabReport::with([
            'sample.labRequest.patient'
        ])
            ->whereHas('sample.labRequest', function ($q) use ($patientId, $testName) {

                $q->where('patient_id', $patientId)
                    ->where('test_name', $testName);

            })
            ->orderBy('created_at')
            ->get();

        return view(
            'doctor.laboratory.compare-reports',
            compact('reports')
        );
    }

    public function reportDetails($id)
    {
        $report = LabReport::with([
            'sample.labRequest.patient',
            'clinicalNotes'
        ])->findOrFail($id);

        return view(
            'doctor.laboratory.report-details',
            compact('report')
        );
    }

    // public function historicalReports()
    // {
    //     $reports = LabReport::with([
    //         'sample.labRequest.patient'
    //     ])
    //         ->where('status', 'Completed')
    //         ->latest()
    //         ->get();

    //     return view(
    //         'doctor.laboratory.historical-reports',
    //         compact('reports')
    //     );
    // }

    public function storeClinicalNote(Request $request)
    {
        $request->validate([

            'patient_id' => 'required',

            'report_id' => 'required'

        ]);

        $note = ClinicalNote::create([

            'patient_id' => $request->patient_id,

            'doctor_id' => auth()->id(),

            'report_id' => $request->report_id,

            'clinical_observation' =>
                $request->clinical_observation,

            'diagnosis' =>
                $request->diagnosis,

            'follow_up_advice' =>
                $request->follow_up_advice

        ]);

        logAudit(
            'clinical_note',
            'NOTE_ADDED',
            $note->id,
            'Doctor added clinical note'
        );

        return back()->with(
            'success',
            'Clinical note added successfully'
        );
    }

    public function apiIndex(Request $request)
    {
        $query = LabRequest::with([
            'patient',
            'sample',
        ]);

        // SEARCH
        if ($request->search) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                // Patient name
                $q->whereHas('patient', function ($patient) use ($search) {

                    $patient->where(
                        'first_name',
                        'like',
                        "%{$search}%"
                    )
                        ->orWhere(
                            'last_name',
                            'like',
                            "%{$search}%"
                        );
                })

                    // Test name
                    ->orWhere(
                        'test_name',
                        'like',
                        "%{$search}%"
                    );
            });
        }

        $requests = $query->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $requests
        ]);
    }

    public function apiCompletedReports(Request $request)
    {
        $query = LabReport::with([
            'sample.labRequest.patient'
        ])
            ->where('status', 'Completed');

        // SEARCH
        if ($request->search) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->whereHas(
                    'sample.labRequest.patient',
                    function ($patient) use ($search) {

                        $patient->where(
                            'first_name',
                            'like',
                            "%{$search}%"
                        )
                            ->orWhere(
                                'last_name',
                                'like',
                                "%{$search}%"
                            );
                    }
                )

                    ->orWhereHas(
                        'sample.labRequest',
                        function ($lab) use ($search) {

                            $lab->where(
                                'test_name',
                                'like',
                                "%{$search}%"
                            );
                        }
                    );
            });
        }

        // DATE FILTER
        if ($request->report_date) {

            $query->whereDate(
                'created_at',
                $request->report_date
            );
        }

        // VERIFICATION STATUS
        if (
            $request->verification_status &&
            $request->verification_status != 'All'
        ) {

            $query->where(
                'verification_status',
                $request->verification_status
            );
        }

        $reports = $query->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $reports
        ]);
    }

    public function apiCompareReports($patientId, $testName)
    {
        $reports = LabReport::with([
            'sample.labRequest.patient'
        ])
            ->whereHas(
                'sample.labRequest',
                function ($q) use ($patientId, $testName) {

                    $q->where(
                        'patient_id',
                        $patientId
                    )
                        ->where(
                            'test_name',
                            $testName
                        );
                }
            )
            ->orderBy('created_at')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $reports
        ]);
    }
    public function apiReportDetails($id)
    {
        $report = LabReport::with([
            'sample.labRequest.patient',
            'clinicalNotes'
        ])->findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $report
        ]);
    }
    public function apiHistoricalReports()
    {
        $reports = LabReport::with([
            'sample.labRequest.patient'
        ])
            ->where('status', 'Completed')
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'data' => $reports
        ]);
    }
    public function apiStoreClinicalNote(Request $request)
    {
        $request->validate([

            'patient_id' =>
                'required|exists:patients,id',

            'report_id' =>
                'required|exists:lab_reports,id'
        ]);

        $note = ClinicalNote::create([

            'patient_id' =>
                $request->patient_id,

            'doctor_id' => 'f6ea9205-63a5-45e5-8233-f41d4466dcb5',

            'report_id' =>
                $request->report_id,

            'clinical_observation' =>
                $request->clinical_observation,

            'diagnosis' =>
                $request->diagnosis,

            'follow_up_advice' =>
                $request->follow_up_advice
        ]);

        logAudit(
            'clinical_note',
            'NOTE_ADDED',
            $note->id,
            'Doctor added clinical note'
        );

        return response()->json([
            'status' => true,
            'message' => 'Clinical note added successfully',
            'data' => $note
        ]);
    }

    public function reportPdf($id)
    {
        $report = LabReport::with([
            'sample.labRequest.patient',
            'clinicalNotes'
        ])->findOrFail($id);

        $pdf = Pdf::loadView(
            'doctor.laboratory.reports-pdf',
            compact('report')
        );

        return $pdf->download('lab-report-' . $report->id . '.pdf');
    }



}