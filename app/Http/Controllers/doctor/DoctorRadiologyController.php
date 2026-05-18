<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ScanRequest;
use App\Models\ScanType;
use App\Models\RadiologyReport;
use App\Models\DoctorRadiologyNote;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;


class DoctorRadiologyController extends Controller
{
   public function index()
{
    $reports = RadiologyReport::with(
        'request.patient',
        'request.scanType'
    )->get();

    return view(
        'doctor.radiology.index',
        compact('reports')
    );
}

    public function create()
    {
        $scanTypes=ScanType::where('status','Active')->get();

        $patients=Patient::all();

        return view('doctor.radiology.create',
            compact('scanTypes','patients')
        );
    }

    public function store(Request $request)
{
    $request->validate([
        'patient_id'   => 'required',
        'scan_type_id' => 'required',
        'body_part'    => 'required',
        'reason'       => 'required'
    ]);

    ScanRequest::create([
        'patient_id'   => $request->patient_id,
        'scan_type_id' => $request->scan_type_id,
        'body_part'    => $request->body_part,
        'reason'       => $request->reason,
        'priority'     => $request->priority ?? 'Normal',
        'doctor_id'    => Auth::id(),
        'status'       => 'Pending'
    ]);

    return redirect()
        ->route('doctor.radiology.index')
        ->with(
            'success',
            'Scan requested successfully'
        );
}

   public function show($id)
{
    $report = RadiologyReport::with(
        'request.patient',
        'request.scanType',
        'request.uploads'
    )->findOrFail($id);

    return view(
        'doctor.radiology.show',
        compact('report')
    );
}

    public function addNote(Request $request)
    {
        $request->validate([
            'report_id'=>'required',
            'notes'=>'required'
        ]);

        $report=RadiologyReport::findOrFail(
            $request->report_id
        );

        DoctorRadiologyNote::create([

            'doctor_id'=>Auth::id(),
            'patient_id'=>$report->request->patient_id,
            'radiology_report_id'=>$report->id,
            'interpretation_notes'=>$request->notes
        ]);

        return back()->with(
            'success',
            'Note added successfully'
        );
    }

    public function download($id)
    {
        $report=RadiologyReport::findOrFail($id);

        $file=$report->request
                    ->uploads
                    ->first();

        return response()->download(
            storage_path(
                'app/public/'.$file->file_path
            )
        );
    }
}
