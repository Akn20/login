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
        $reports = RadiologyReport::with('request.patient','request.scanType')->get();

        return view('doctor.radiology.index', compact('reports'));
    }


    public function create()
    {
        $scanTypes=ScanType::where('status','Active')->get();

        $patients=Patient::all();

        return view('doctor.radiology.create', compact('scanTypes','patients'));
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

        return redirect()->route('doctor.radiology.index') ->with('success','Scan requested successfully');
    }


    public function show($id)
    {
        $report = RadiologyReport::with(
            'request.patient',
            'request.scanType',
            'request.uploads'
        )->findOrFail($id);

        $notes = DoctorRadiologyNote::where(
            'radiology_report_id',
            $report->id
        )->latest()->get();

        return view(
            'doctor.radiology.show',
            compact('report','notes')
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

        return back()->with('success','Note added successfully');
    }

    public function download($id)
    {
        $report=RadiologyReport::findOrFail($id);

        $file=$report->request ->uploads->first();

        return response()->download(storage_path('app/public/'.$file->file_path));
    }

    // API Methods
    public function apiIndex()
    {
        $reports = RadiologyReport::with('request.patient', 'request.scanType')
            ->latest()
            ->get()
            ->map(function ($report) {
                return [
                    'id' => (string) $report->id,
                    'patientName' => trim(
                        optional($report->request->patient)->first_name . ' ' .
                        optional($report->request->patient)->last_name
                    ),
                    'scanTypeName' => optional($report->request->scanType)->name ?? '-',
                    'status' => $report->status,
                    'reportDate' => optional($report->created_at)->format('Y-m-d'),
                ];
            });

        return response()->json([
            'status' => true,
            'data' => $reports,
        ]);
    }

    public function apiCreateData()
    {
        return response()->json([
            'status' => true,
            'data' => [
                'scanTypes' => ScanType::where('status', 'Active')->get(),
                'patients' => Patient::select('id', 'first_name', 'last_name')->get(),
            ],
        ]);
    }

    public function apiStore(Request $request)
    {
        $request->validate([
            'patient_id'   => 'required',
            'scan_type_id' => 'required',
            'body_part'    => 'required',
            'reason'       => 'required',
        ]);

        $doctorId = Auth::id()
            ?? $request->doctor_id
            ?? \App\Models\User::query()
                ->join('roles', 'users.role_id', '=', 'roles.id')
                ->where('roles.name', 'like', '%doctor%')
                ->value('users.id');

        if (!$doctorId) {
            return response()->json([
                'status' => false,
                'message' => 'Doctor is required',
            ], 422);
        }

        $scanRequest = ScanRequest::create([
            'patient_id'   => $request->patient_id,
            'scan_type_id' => $request->scan_type_id,
            'body_part'    => $request->body_part,
            'reason'       => $request->reason,
            'priority'     => $request->priority ?? 'Normal',
            'doctor_id'    => $doctorId,
            'status'       => 'Pending',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Scan requested successfully',
            'data' => $scanRequest,
        ]);
    }

    public function apiShow($id)
    {
        $report = RadiologyReport::with(
            'request.patient',
            'request.scanType',
            'request.uploads'
        )->findOrFail($id);

        $notes = DoctorRadiologyNote::where('radiology_report_id', $report->id)
            ->latest()
            ->get()
            ->map(function ($note) {
                return [
                    'id' => $note->id,
                    'interpretation_notes' => $note->interpretation_notes,
                    'created_at' => optional($note->created_at)->format('d-m-Y h:i A'),
                ];
            });

        return response()->json([
            'status' => true,
            'data' => [
                'id' => (string) $report->id,
                'patientName' => trim(
                    optional($report->request->patient)->first_name . ' ' .
                    optional($report->request->patient)->last_name
                ),
                'scanTypeName' => optional($report->request->scanType)->name ?? '-',
                'status' => $report->status,
                'reportDate' => optional($report->created_at)->format('Y-m-d'),
                'findings' => $report->findings,
                'diagnosis' => $report->diagnosis,
                'bodyPart' => $report->request->body_part,
                'reason' => $report->request->reason,
                'uploads' => $report->request->uploads,
                'notes' => $notes,
            ],
        ]);
    }

    public function apiAddNote(Request $request)
    {
        $request->validate([
            'report_id' => 'required',
            'notes' => 'required',
        ]);

        $report = RadiologyReport::with('request')->findOrFail($request->report_id);
        $doctorId = Auth::id()
            ?? $request->doctor_id
            ?? \App\Models\User::query()
                ->join('roles', 'users.role_id', '=', 'roles.id')
                ->where('roles.name', 'like', '%doctor%')
                ->value('users.id');

        if (!$doctorId) {
            return response()->json([
                'status' => false,
                'message' => 'Doctor is required',
            ], 422);
        }

        $note = DoctorRadiologyNote::create([
            'doctor_id' => $doctorId,
            'patient_id' => $report->request->patient_id,
            'radiology_report_id' => $report->id,
            'interpretation_notes' => $request->notes,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Note added successfully',
            'data' => $note,
        ]);
    }

    public function apiDownload($id)
    {
        $report = RadiologyReport::with('request.uploads')->findOrFail($id);
        $file = $report->request->uploads->first();

        if (!$file) {
            return response()->json([
                'status' => false,
                'message' => 'No scan file found',
            ], 404);
        }

        return response()->download(storage_path('app/public/' . $file->file_path));
    }
}
