<?php

namespace App\Http\Controllers\Admin\Nurse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrescriptionItem;
use App\Models\LabRequest;
use App\Models\ScanRequest;
use App\Models\MedicationAdministration;
use App\Models\DoctorOrderExecution;

use Illuminate\Support\Facades\DB;

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
$medications = DB::table('ipd_prescription_items as items')
    ->join('ipd_prescriptions as prescriptions', 'items.prescription_id', '=', 'prescriptions.id')
    ->join('patients', 'prescriptions.patient_id', '=', 'patients.id')
    ->select(
        'items.*',
        'prescriptions.patient_id',
        'patients.first_name',
        'patients.last_name'
    )
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
$medication = DB::table('ipd_prescription_items as items')
    ->join('ipd_prescriptions as prescriptions', 'items.prescription_id', '=', 'prescriptions.id')
    ->join('patients', 'prescriptions.patient_id', '=', 'patients.id')
    ->where('items.id', $id)
    ->select(
        'items.*',
        'prescriptions.patient_id',
        'patients.first_name',
        'patients.last_name'
    )
    ->first();

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
    if ($request->type == 'Lab') {

        $order = LabRequest::findOrFail($id);

        $order->update([
            'status' => 'completed'
        ]);

        DoctorOrderExecution::create([
            'order_type' => 'Lab',
            'order_reference_id' => $id,
            'patient_id' => $order->patient_id,
            'execution_status' => 'Executed',
            'remarks' => $request->remarks,
            'executed_by' => auth()->id(),
            'executed_at' => now()
        ]);
    }

    elseif ($request->type == 'Radiology') {

        $order = ScanRequest::findOrFail($id);

        $order->update([
            'status' => 'Approved'
        ]);
DB::table('ipd_prescription_items')
    ->where('id', $id)
    ->update([
        'status' => 'completed'
    ]);
        DoctorOrderExecution::create([
            'order_type' => 'Radiology',
            'order_reference_id' => $id,
            'patient_id' => $order->patient_id,
            'execution_status' => 'Executed',
            'remarks' => $request->remarks,
            'executed_by' => auth()->id(),
            'executed_at' => now()
        ]);
    }
elseif ($request->type == 'Medication') {

    DB::table('ipd_prescription_items')
        ->where('id', $id)
        ->update([
            'status' => 'Completed'
        ]);

  $prescription = DB::table('ipd_prescription_items as items')
    ->join('ipd_prescriptions as prescriptions', 'items.prescription_id', '=', 'prescriptions.id')
    ->where('items.id', $id)
    ->select('prescriptions.patient_id')
    ->first();

DoctorOrderExecution::create([
    'order_type' => 'Medication',
    'order_reference_id' => $id,
    'patient_id' => $prescription->patient_id,
        'execution_status' => 'Executed',
        'remarks' => $request->remarks,
        'executed_by' => auth()->id(),
        'executed_at' => now()
    ]);
}

    return redirect()
        ->route('admin.doctor-order-execution.index')
        ->with('success', 'Order Executed Successfully');
}

public function escalate(Request $request, $id)
{
    if ($request->type == 'Lab') {

        $order = LabRequest::findOrFail($id);

        $order->update([
            'status' => 'in_progress'
        ]);

        DoctorOrderExecution::create([
            'order_type' => 'Lab',
            'order_reference_id' => $id,
            'patient_id' => $order->patient_id,
            'execution_status' => 'Escalated',
            'escalation_reason' => $request->reason,
            'executed_by' => auth()->id()
        ]);
    }

    elseif ($request->type == 'Radiology') {

        $order = ScanRequest::findOrFail($id);

        $order->update([
            'status' => 'Under Review'
        ]);

        DoctorOrderExecution::create([
            'order_type' => 'Radiology',
            'order_reference_id' => $id,
            'patient_id' => $order->patient_id,
            'execution_status' => 'Escalated',
            'escalation_reason' => $request->reason,
            'executed_by' => auth()->id()
        ]);
    }
    elseif ($request->type == 'Medication') {

   DB::table('ipd_prescription_items')
    ->where('id', $id)
    ->update([
        'status' => 'Missed'
    ]);

$prescription = DB::table('ipd_prescription_items as items')
    ->join('ipd_prescriptions as prescriptions', 'items.prescription_id', '=', 'prescriptions.id')
    ->where('items.id', $id)
    ->select('prescriptions.patient_id')
    ->first();

DoctorOrderExecution::create([
    'order_type' => 'Medication',
    'order_reference_id' => $id,
    'patient_id' => $prescription->patient_id,
        'execution_status' => 'Escalated',
        'escalation_reason' => $request->reason,
        'executed_by' => auth()->id()
    ]);
}

    return redirect()
        ->route('admin.doctor-order-execution.index')
        ->with('success', 'Order Escalated Successfully');
}
//-----------api---------------------------------
public function apiIndex()
{
    $labRequests = LabRequest::with('patient')
        ->latest()
        ->get()
        ->map(function ($item) {

            return [
                'id' => $item->id,
                'type' => 'Lab',
                'patient_name' =>
                    optional($item->patient)->name,
                'status' =>
                    $item->status,
                'created_at' =>
                    $item->created_at,
            ];
        });

    $scanRequests = ScanRequest::with([
        'patient',
        'scanType'
    ])
    ->latest()
    ->get()
    ->map(function ($item) {

        return [
            'id' => $item->id,
            'type' => 'Radiology',
            'patient_name' =>
                optional($item->patient)->name,
            'scan_type' =>
                optional($item->scanType)->name,
            'status' =>
                $item->status,
            'created_at' =>
                $item->created_at,
        ];
    });

    $medications = MedicationAdministration::with([
        'patient',
        'prescriptionItem.medicine'
    ])
    ->latest()
    ->get()
    ->map(function ($item) {

        return [
            'id' => $item->id,
            'type' => 'Medication',
            'patient_name' =>
                optional($item->patient)->name,
            'medicine' =>
                optional(
                    optional(
                        $item->prescriptionItem
                    )->medicine
                )->medicine_name,
            'status' =>
                $item->status,
            'created_at' =>
                $item->created_at,
        ];
    });

    $orders = collect()
        ->merge($labRequests)
        ->merge($scanRequests)
        ->merge($medications)
        ->sortByDesc('created_at')
        ->values();

    return response()->json($orders);
}
public function apiShow($id)
{
    $labRequest = LabRequest::with([
        'patient',
        'consultation'
    ])->find($id);

    if ($labRequest) {

        return response()->json([
            'data' => $labRequest,
            'type' => 'Lab'
        ]);
    }

    $scanRequest = ScanRequest::with([
        'patient',
        'scanType'
    ])->find($id);

    if ($scanRequest) {

        return response()->json([
            'data' => $scanRequest,
            'type' => 'Radiology'
        ]);
    }

    $medication =
        MedicationAdministration::with([
            'patient',
            'prescriptionItem.medicine'
        ])->find($id);

    if ($medication) {

        return response()->json([
            'data' => $medication,
            'type' => 'Medication'
        ]);
    }

    return response()->json([
        'message' => 'Not Found'
    ], 404);
}
public function apiExecute(
    Request $request,
    $id
)
{
    $labRequest =
        LabRequest::findOrFail($id);

    DoctorOrderExecution::create([

        'order_type' => 'Lab',

        'order_reference_id' => $id,

        'patient_id' =>
            $labRequest->patient_id,

        'execution_status' =>
            'Executed',

        'remarks' =>
            $request->remarks,

        'executed_by' =>
            1,

        'executed_at' =>
            now(),

    ]);

    $labRequest->update([
        'status' => 'completed'
    ]);

    return response()->json([
        'message' =>
            'Order Executed Successfully'
    ]);
}
public function apiEscalate(
    Request $request,
    $id
)
{
    $labRequest =
        LabRequest::findOrFail($id);

    DoctorOrderExecution::create([

        'order_type' => 'Lab',

        'order_reference_id' => $id,

        'patient_id' =>
            $labRequest->patient_id,

        'execution_status' =>
            'Escalated',

        'escalation_reason' =>
            $request->reason,

        'executed_by' =>
            1,

    ]);

    $labRequest->update([
        'status' => 'in_progress'
    ]);

    return response()->json([
        'message' =>
            'Order Escalated Successfully'
    ]);
}
}