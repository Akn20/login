<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClinicalNote;
use App\Models\LabReport;
use App\Models\LabRequest;
use App\Models\Patient;

class ClinicalNoteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'report_id' => 'required',
            'patient_id' => 'required'
        ]);

        $note = ClinicalNote::create([

            'patient_id' => $request->patient_id,

            'doctor_id' => auth()->id(),

            'report_id' => $request->report_id,

            'clinical_observation' => $request->clinical_observation,

            'diagnosis' => $request->diagnosis,

            'follow_up_advice' => $request->follow_up_advice

        ]);


        return back()->with('success', 'Clinical note added');
    }

    public function show($reportId)
    {
        $report = LabReport::with([
            'sample.labRequest.patient',
            'clinicalNotes.doctor'
        ])->findOrFail($reportId);

        return view(
            'doctor.laboratory.report-details',
            compact('report')
        );
    }

    public function index()
    {
        $reports = LabReport::with([
            'sample.labRequest.patient',
            'clinicalNotes.doctor'
        ])
            ->whereHas('sample.labRequest', function ($query) {
                $query->where('doctor_id', auth()->id());
            })
            ->latest()
            ->get();

        return view(
            'doctor.laboratory.laboratory-reports',
            compact('reports')
        );

    }

    public function historical()
    {
        $reports = LabReport::with([
            'sample.labRequest.patient',
            'clinicalNotes.doctor'
        ])
            ->whereHas('sample.labRequest', function ($query) {
                $query->where('doctor_id', auth()->id());
            })
            ->where('status', 'Completed')
            ->latest()
            ->get();

        return view(
            'doctor.laboratory.historical-reports',
            compact('reports')
        );

    }

    public function apiStore(Request $request)
    {
        $request->validate([

            'report_id' =>
                'required|exists:lab_reports,id',

            'patient_id' =>
                'required|exists:patients,id',
        ]);

        $note = ClinicalNote::create([

            'patient_id' =>
                $request->patient_id,

            'doctor_id' =>
                'f6ea9205-63a5-45e5-8233-f41d4466dcb5',

            'report_id' =>
                $request->report_id,

            'clinical_observation' =>
                $request->clinical_observation,

            'diagnosis' =>
                $request->diagnosis,

            'follow_up_advice' =>
                $request->follow_up_advice
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Clinical note added successfully',
            'data' => $note
        ]);
    }

    public function apiShow($reportId)
    {
        $report = LabReport::with([
            'sample.labRequest.patient',
            'clinicalNotes.doctor'
        ])->findOrFail($reportId);

        return response()->json([
            'status' => true,
            'data' => $report
        ]);
    }

    public function apiIndex()
    {
        $reports = LabReport::with([
            'sample.labRequest.patient',
            'clinicalNotes.doctor'
        ])
            ->whereHas('sample.labRequest', function ($query) {

                $query->where(
                    'doctor_id',
                    auth()->id()
                );
            })
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'data' => $reports
        ]);
    }

    public function apiHistorical()
    {
        $reports = LabReport::with([
            'sample.labRequest.patient',
            'clinicalNotes.doctor'
        ])
            ->whereHas('sample.labRequest', function ($query) {

                $query->where(
                    'doctor_id',
                    auth()->id()
                );
            })
            ->where('status', 'Completed')
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'data' => $reports
        ]);
    }

    public function apiSearch(Request $request)
    {
        $query = LabReport::with([
            'sample.labRequest.patient',
            'clinicalNotes.doctor'
        ]);

        // Search by patient name
        if ($request->filled('search')) {

            $query->whereHas(
                'sample.labRequest.patient',
                function ($q) use ($request) {

                    $q->where(
                        'first_name',
                        'LIKE',
                        '%' . $request->search . '%'
                    )
                        ->orWhere(
                            'last_name',
                            'LIKE',
                            '%' . $request->search . '%'
                        );
                }
            );
        }

        // Filter completed reports
        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }

        $reports = $query->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $reports
        ]);
    }
}
