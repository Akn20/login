<?php

namespace App\Http\Controllers\Admin\Nurse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\LabRequest;
use App\Models\ScanRequest;
use App\Models\MedicationAdministration;
use App\Models\DoctorOrderExecution;

class DoctorOrderExecutionController extends Controller
{
    public function index()
    {
        $labRequests = LabRequest::with('patient')
            ->latest()
            ->get();

        $scanRequests = ScanRequest::with([
            'patient',
            'scanType'
        ])
        ->latest()
        ->get();

        $medications = MedicationAdministration::with([
            'patient',
            'prescriptionItem.medicine'
        ])
        ->latest()
        ->get();

        return view(
            'admin.nurse.doctor_order_execution.index',
            compact(
                'labRequests',
                'scanRequests',
                'medications'
            )
        );
    }

    public function show($id)
    {
        $labRequest = LabRequest::with([
            'patient',
            'consultation'
        ])->find($id);

        if ($labRequest) {

            return view(
                'admin.nurse.doctor_order_execution.show',
                [
                    'order' => $labRequest,
                    'type' => 'Lab'
                ]
            );
        }

        $scanRequest = ScanRequest::with([
            'patient',
            'scanType'
        ])->find($id);

        if ($scanRequest) {

            return view(
                'admin.nurse.doctor_order_execution.show',
                [
                    'order' => $scanRequest,
                    'type' => 'Radiology'
                ]
            );
        }

        $medication = MedicationAdministration::with([
            'patient',
            'prescriptionItem.medicine'
        ])->find($id);

        if ($medication) {

            return view(
                'admin.nurse.doctor_order_execution.show',
                [
                    'order' => $medication,
                    'type' => 'Medication'
                ]
            );
        }

        abort(404);
    }

public function execute(Request $request, $id)
{
    $labRequest = LabRequest::find($id);

    if (!$labRequest) {
        abort(404);
    }

    DoctorOrderExecution::create([

        'order_type' => 'Lab',

        'order_reference_id' => $id,

        'patient_id' => $labRequest->patient_id,

        'execution_status' => 'Executed',

        'remarks' => $request->remarks,

        'executed_by' => auth()->id(),

        'executed_at' => now()

    ]);

    $labRequest->update([
        'status' => 'completed'
    ]);

    return redirect()
        ->route('admin.doctor-order-execution.index')
        ->with(
            'success',
            'Order Executed Successfully'
        );
}

  public function escalate(Request $request, $id)
{
    $labRequest = LabRequest::find($id);

    if (!$labRequest) {
        abort(404);
    }

    DoctorOrderExecution::create([

        'order_type' => 'Lab',

        'order_reference_id' => $id,

        'patient_id' => $labRequest->patient_id,

        'execution_status' => 'Escalated',

        'escalation_reason' => $request->reason,

        'executed_by' => auth()->id()

    ]);

    $labRequest->update([
        'status' => 'in_progress'
    ]);

    return redirect()
        ->route('admin.doctor-order-execution.index')
        ->with(
            'success',
            'Order Escalated Successfully'
        );
}
}