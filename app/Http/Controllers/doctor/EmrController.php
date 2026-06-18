<?php

namespace App\Http\Controllers\doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Consultation;
use App\Models\Prescription;
use App\Models\LabRequest;
use App\Models\ScanRequest;
use App\Models\Surgery;
use App\Models\IpdAdmission;

class EmrController extends Controller
{
    public function index()
    {
        $patients = Patient::latest()->get();

        return view('doctor.emr.index',compact('patients'));
    }

    
    public function show($id)
    {
        $patient = Patient::findOrFail($id);

        // OPD history
        $consultations = Consultation::with(['doctor','medicines'])
        ->where('patient_id', $id)
        ->latest('consultation_date')
        ->get();

        // Lab history
        $labs = LabRequest::where('patient_id',$id)->latest()->get();

        // Radiology history
        $scans = ScanRequest::with(['scanType', 'report'])
        ->where(
            'patient_id',
            $id
        )->latest() ->get();

        // Surgery history
        $surgeries = Surgery::where('patient_id',$id)->latest()->get();

        // IPD history
        $ipdHistory = IpdAdmission::with(['ward','bed'])
        ->where(
            'patient_id',
            $id
        )
        ->latest()
        ->get();

        return view('doctor.emr.show',
            compact(
                'patient',
                'consultations',
                'labs',
                'scans',
                'surgeries',
                'ipdHistory'
            )
        );
    }

    // API methods for EMR 
    public function apiIndex()
    {
        $patients = Patient::latest()
            ->get()
            ->map(function ($patient) {
                return [
                    'id' => (string) $patient->id,
                    'patientCode' => $patient->patient_code,
                    'patientName' => trim($patient->first_name . ' ' . $patient->last_name),
                    'gender' => $patient->gender,
                    'mobile' => $patient->mobile,
                ];
            });

        return response()->json([
            'status' => true,
            'data' => $patients,
        ]);
    }

    public function apiShow($id)
    {
        $patient = Patient::findOrFail($id);

        $consultations = Consultation::with(['doctor', 'medicines'])
            ->where('patient_id', $id)
            ->latest('consultation_date')
            ->get()
            ->map(function ($consultation) {
                return [
                    'id' => $consultation->id,
                    'date' => $consultation->consultation_date
                        ? \Carbon\Carbon::parse($consultation->consultation_date)->format('d-m-Y')
                        : null,
                    'symptoms' => $consultation->symptoms,
                    'diagnosis' => $consultation->diagnosis,
                    'tests' => $consultation->tests,
                ];
            });

        $labs = LabRequest::where('patient_id', $id)
            ->latest()
            ->get()
            ->map(function ($lab) {
                return [
                    'id' => $lab->id,
                    'test' => $lab->test_name,
                    'priority' => $lab->priority,
                    'status' => $lab->status,
                ];
            });

        $scans = ScanRequest::with(['scanType', 'report'])
            ->where('patient_id', $id)
            ->latest()
            ->get()
            ->map(function ($scan) {
                return [
                    'id' => (string) $scan->id,
                    'scan' => optional($scan->scanType)->name ?? '-',
                    'bodyPart' => $scan->body_part,
                    'status' => $scan->status,
                ];
            });

        $surgeries = Surgery::where('patient_id', $id)
            ->latest()
            ->get()
            ->map(function ($surgery) {
                return [
                    'id' => $surgery->id,
                    'surgery' => $surgery->surgery_type,
                    'date' => $surgery->surgery_date,
                    'otRoom' => $surgery->ot_room,
                ];
            });

        $ipdHistory = IpdAdmission::with(['ward', 'bed'])
            ->where('patient_id', $id)
            ->latest()
            ->get()
            ->map(function ($ipd) {
                return [
                    'id' => $ipd->id,
                    'admissionDate' => $ipd->admission_date,
                    'ward' => optional($ipd->ward)->ward_name ?? '-',
                    'bed' => optional($ipd->bed)->bed_number ?? '-',
                    'status' => $ipd->status,
                ];
            });

        return response()->json([
            'status' => true,
            'data' => [
                'patient' => [
                    'id' => (string) $patient->id,
                    'patientCode' => $patient->patient_code,
                    'patientName' => trim($patient->first_name . ' ' . $patient->last_name),
                    'gender' => $patient->gender,
                    'mobile' => $patient->mobile,
                ],
                'consultations' => $consultations,
                'labs' => $labs,
                'scans' => $scans,
                'surgeries' => $surgeries,
                'ipdHistory' => $ipdHistory,
            ],
        ]);
    }

}
