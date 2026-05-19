<?php

namespace App\Http\Controllers\doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MedicalCertification;
use Illuminate\Support\Str;
use App\Models\Staff;
use Barryvdh\DomPDF\Facade\Pdf;

class MedicalCertificationController extends Controller
{
    public function index()
    {
        MedicalCertification::where(
    'valid_until',
    '<',
    now()->toDateString()
)
->where('status', 'Signed')
->update([
    'status' => 'Expired'
]);
        $records = MedicalCertification::latest()
            ->paginate(10);
            return view(
            'doctor.medical_certification.index',
            compact('records')
        );
    }

   public function create()
{
    $employees = Staff::with(
    'department',
    'designation'
)->get();

    return view(
        'doctor.medical_certification.create',
        compact('employees')
    );
}
     public function store(Request $request)
{
    $staff = Staff::where(
        'employee_id',
        $request->employee_id
    )->first();

    $request->validate([

        'employee_id'      => 'required',
        'certificate_type' => 'required',
        'issue_date'       => 'required',
        'valid_from'       => 'required',
        'valid_until'      => 'required',
        'doctor_name'      => 'required',
    ]);

    MedicalCertification::create([

        'id' => Str::uuid(),

        'employee_id'   => $request->employee_id,

        'employee_name' => $staff->name,

        'department'    => $request->department,

        'designation'   => $request->designation,

        'certificate_type' => $request->certificate_type,

        'issue_date' => $request->issue_date,

        'valid_from' => $request->valid_from,

        'valid_until' => $request->valid_until,

        'diagnosis_reason' => $request->diagnosis_reason,

        'medical_remarks' => $request->medical_remarks,

        'doctor_name' => $request->doctor_name,

        'registration_number' => $request->registration_number,

        'hospital_name' => $request->hospital_name,

        'status' => 'Draft',

'action_history' =>

    'Certificate created by '

    . auth()->user()->name

    . ' on '

    . now(),
    

        'certificate_number' =>
            'MC-' . rand(1000, 9999),
    ]);

    return redirect()
        ->route('doctor.medical-certification.index')
        ->with('success', 'Created Successfully');
}
     public function show($id)
    {
        $record = MedicalCertification::findOrFail($id);

        return view(
            'doctor.medical_certification.show',
            compact('record')
        );
    }

 public function edit($id)
{
    $record = MedicalCertification::findOrFail($id);

    if ($record->signature_status) {

        return back()->with(
            'error',
            'Signed certificate cannot be edited'
        );
    }

$employees = Staff::with(
    'department',
    'designation'
)->get();

    return view(
        'doctor.medical_certification.edit',
        compact(
            'record',
            'employees'
        )
    );
}

    public function update(Request $request, $id)
{
    $record = MedicalCertification::findOrFail($id);

    if ($record->signature_status) {

        return back()->with(
            'error',
            'Signed certificate cannot be edited'
        );
    }

    $staff = Staff::where(
        'employee_id',
        $request->employee_id
    )->first();

    $request->validate([

        'employee_id'      => 'required',
        'certificate_type' => 'required',
        'issue_date'       => 'required',
        'valid_from'       => 'required',
        'valid_until'      => 'required',
        'doctor_name'      => 'required',
    ]);

    $record->update([

        'employee_id'   => $request->employee_id,

        'employee_name' => $staff->name,

        'department'    => $request->department,

        'designation'   => $request->designation,

        'certificate_type' => $request->certificate_type,

        'issue_date' => $request->issue_date,

        'valid_from' => $request->valid_from,

        'valid_until' => $request->valid_until,

        'diagnosis_reason' => $request->diagnosis_reason,

        'medical_remarks' => $request->medical_remarks,

        'doctor_name' => $request->doctor_name,

        'registration_number' => $request->registration_number,

        'hospital_name' => $request->hospital_name,
    ]);

    return redirect()
        ->route('doctor.medical-certification.index')
        ->with('success', 'Updated Successfully');
}
    public function sign($id)
{
    $record = MedicalCertification::findOrFail($id);

    $record->update([

        'signature_status' => 1,

        'status' => 'Signed',

        'signed_by' => auth()->user()->name,

        'signed_at' => now(),

        'action_history' =>

            ($record->action_history ?? '')

            . "\nCertificate signed by "

            . auth()->user()->name

            . " on "

            . now(),

    ]);

    return back()->with(
        'success',
        'Certificate Signed Successfully'
    );
}
public function downloadPdf($id)
{
    $record = MedicalCertification::findOrFail($id);
    $record->update([

    'action_history' =>

        ($record->action_history ?? '')

        . "\nCertificate downloaded by "

        . auth()->user()->name

        . " on "

        . now(),

]);

    $pdf = Pdf::loadView(
        'doctor.medical_certification.pdf',
        compact('record')
    );

    return $pdf->download(
        $record->certificate_number . '.pdf'
    );
}
public function cancel($id)
{
    $record = MedicalCertification::findOrFail($id);

    $record->update([

        'status' => 'Cancelled',

        'action_history' =>

            ($record->action_history ?? '')

            . "\nCertificate cancelled by "

            . auth()->user()->name

            . " on "

            . now(),

    ]);

    return back()->with(
        'success',
        'Certificate Cancelled Successfully'
    );
}
public function printPdf($id)
{
    $record = MedicalCertification::findOrFail($id);
    $record->update([

    'action_history' =>

        ($record->action_history ?? '')

        . "\nCertificate printed by "

        . auth()->user()->name

        . " on "

        . now(),

]);

    $pdf = Pdf::loadView(
        'doctor.medical_certification.pdf',
        compact('record')
    );

    return $pdf->stream(
        $record->certificate_number . '.pdf'
    );
}
    public function destroy($id)
    {
        $record = MedicalCertification::findOrFail($id);

        if ($record->signature_status) {

            return back()->with(
                'error',
                'Signed certificate cannot be deleted'
            );
        }

        $record->delete();

        return back()->with(
            'success',
            'Deleted Successfully'
        );
    }

    // ================= API METHODS ================= //

public function apiIndex()
{
    $records = MedicalCertification::latest()
        ->get();

    return response()->json([
        'success' => true,
        'data' => $records
    ]);
}

public function apiShow($id)
{
    $record = MedicalCertification::findOrFail($id);

    return response()->json([
        'success' => true,
        'data' => $record
    ]);
}

public function apiStore(Request $request)
{
    $staff = Staff::where(
        'employee_id',
        $request->employee_id
    )->first();

    $record = MedicalCertification::create([

        'id' => Str::uuid(),

        'employee_id' => $request->employee_id,

        'employee_name' => $staff->name,

        'department' => optional($staff->department)->department_name,

        'designation' => optional($staff->designation)->designation_name,

        'certificate_type' => $request->certificate_type,

        'issue_date' => $request->issue_date,

        'valid_from' => $request->valid_from,

        'valid_until' => $request->valid_until,

        'diagnosis_reason' => $request->diagnosis_reason,

        'medical_remarks' => $request->medical_remarks,

        'doctor_name' => $request->doctor_name,

        'registration_number' => $request->registration_number,

        'hospital_name' => $request->hospital_name,

        'certificate_number' =>
            'MC-' . rand(1000, 9999),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Created Successfully',
        'data' => $record
    ]);
}

public function apiUpdate(Request $request, $id)
{
    $record = MedicalCertification::findOrFail($id);

    $staff = Staff::where(
        'employee_id',
        $request->employee_id
    )->first();

    $record->update([

        'employee_id' => $request->employee_id,

        'employee_name' => $staff->name,

        'department' => optional($staff->department)->department_name,

        'designation' => optional($staff->designation)->designation_name,

        'certificate_type' => $request->certificate_type,

        'issue_date' => $request->issue_date,

        'valid_from' => $request->valid_from,

        'valid_until' => $request->valid_until,

        'diagnosis_reason' => $request->diagnosis_reason,

        'medical_remarks' => $request->medical_remarks,

        'doctor_name' => $request->doctor_name,

        'registration_number' => $request->registration_number,

        'hospital_name' => $request->hospital_name,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Updated Successfully',
        'data' => $record
    ]);
}

public function apiDelete($id)
{
    MedicalCertification::findOrFail($id)
        ->delete();

    return response()->json([
        'success' => true,
        'message' => 'Deleted Successfully'
    ]);
}

public function apiSign($id)
{
    $record = MedicalCertification::findOrFail($id);

    $record->update([

        'signature_status' => 1,

        'signed_by' => auth()->user()->name ?? 'Doctor',

        'signed_at' => now(),

        'status' => 'Signed'
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Certificate Signed Successfully'
    ]);
}
}