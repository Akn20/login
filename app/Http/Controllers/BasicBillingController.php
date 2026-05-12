<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReceptionistBilling;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Appointment;

class BasicBillingController extends Controller
{
    public function index(Request $request)
{
    $query = ReceptionistBilling::with('patient');

    if ($request->patient) {
        $query->whereHas('patient', function ($q) use ($request) {
            $q->where('first_name', 'like', "%{$request->patient}%")
              ->orWhere('last_name', 'like', "%{$request->patient}%")
              ->orWhere('patient_code', 'like', "%{$request->patient}%");
        });
    }

    if ($request->date) {
        $query->whereDate('created_at', $request->date);
    }

    $billings = $query->latest()->get();

    return view('admin.Receptionist.billing.index', compact('billings'));
}


public function create()
{
    $appointments = Appointment::with('patient')
        ->where('appointment_status', 'Scheduled')
        ->latest()
        ->get();

    return view('admin.Receptionist.billing.create', compact('appointments'));
}

public function store(Request $request)
{
    $request->validate([
        'appointment_id' => 'required|exists:appointments,id'
    ]);

    // ❗ Duplicate check
    $exists = ReceptionistBilling::where('visit_id', $request->appointment_id)->exists();

    if ($exists) {
        return back()->with('error', 'Payment already collected for this appointment');
    }

    DB::beginTransaction();

    try {

        $appointment = Appointment::findOrFail($request->appointment_id);

        $last = ReceptionistBilling::latest()->first();
        $number = $last ? intval(substr($last->receipt_no, 4)) + 1 : 1;
        $receipt_no = 'RCPT' . str_pad($number, 4, '0', STR_PAD_LEFT);

        $billing = ReceptionistBilling::create([
            'id' => (string) \Str::uuid(),
            'receipt_no' => $receipt_no,
            'patient_id' => $appointment->patient_id,
            'visit_id' => $appointment->id,
            'amount' => $appointment->consultation_fee,
            'payment_mode' => 'CASH',
            'collected_by' => auth()->id() ?? 'DEFAULT-UUID'
        ]);

        DB::commit();

        return redirect()->route('admin.billing.receipt', $billing->id);

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', $e->getMessage());
    }
}

public function show($id)
{
    $billing = ReceptionistBilling::with('patient')->findOrFail($id);
    return view('admin.Receptionist.billing.show', compact('billing'));
}

public function receipt($id)
{
    $billing = ReceptionistBilling::with('patient')->findOrFail($id);
    return view('admin.Receptionist.billing.receipt', compact('billing'));
}

//API

public function apiIndex()
{
    $billings = ReceptionistBilling::with('patient')
        ->latest()
        ->get();

    return response()->json([
        'status' => true,
        'data' => $billings
    ]);
}
public function apiAppointments()
{
    $appointments = Appointment::with('patient')
        ->where('appointment_status', 'Scheduled')
        ->get();

    return response()->json([
        'status' => true,
        'data' => $appointments
    ]);
}
public function apiStore(Request $request)
{
    $request->validate([
        'appointment_id' => 'required|exists:appointments,id'
    ]);

    DB::beginTransaction();

    try {

        // ❗ Prevent duplicate billing
        $exists = ReceptionistBilling::where('visit_id', $request->appointment_id)->exists();

        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'Already billed'
            ]);
        }

        $appointment = Appointment::findOrFail($request->appointment_id);

        // 🔢 Receipt number
        $last = ReceptionistBilling::latest()->first();
        $number = $last ? intval(substr($last->receipt_no, 4)) + 1 : 1;
        $receipt_no = 'RCPT' . str_pad($number, 4, '0', STR_PAD_LEFT);

        $billing = ReceptionistBilling::create([
            'id' => (string) \Str::uuid(),
            'receipt_no' => $receipt_no,
            'patient_id' => $appointment->patient_id,
            'visit_id' => $appointment->id,
            'amount' => $appointment->consultation_fee,
            'payment_mode' => 'CASH',
            'collected_by' => $request->collected_by 
                        ?? auth()->id() 
                        ?? '5e87dc64-1d13-11f1-90d4-8cb0e9e55cf4',
            'hospital_id' => auth()->user()->hospital_id ?? null
        ]);

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Billing created successfully',
            'data' => $billing
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ]);
    }
}
public function apiShow($id)
{
    $billing = ReceptionistBilling::with('patient')->find($id);

    if (!$billing) {
        return response()->json([
            'status' => false,
            'message' => 'Billing not found'
        ]);
    }

    return response()->json([
        'status' => true,
        'data' => $billing
    ]);
}
}