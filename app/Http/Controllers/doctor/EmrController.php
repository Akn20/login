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

}
