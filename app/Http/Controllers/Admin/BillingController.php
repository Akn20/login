<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReceptionistBilling;
use App\Models\Patient;
use Illuminate\Support\Str;
use PDF; // barryvdh/laravel-dompdf

class BillingController extends Controller
{
    // 🔹 List
    public function index()
    {
        $billings = ReceptionistBilling::with('patient')
            ->latest()
            ->paginate(10);

        return view('admin.billing.index', compact('billings'));
    }

    // 🔹 Create form
    public function create()
    {
        $patients = Patient::selectRaw("CONCAT(first_name, ' ', last_name) as name, id")
    ->pluck('name', 'id');
        return view('admin.billing.create', compact('patients'));
    }

    // 🔹 Store
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'amount' => 'required|numeric',
            'payment_mode' => 'required'
        ]);

        ReceptionistBilling::create([
            'id' => (string) Str::uuid(),
            'receipt_no' => 'RCPT-' . time(),
            'patient_id' => $request->patient_id,
            'visit_id' => $request->visit_id,
            'amount' => $request->amount,
            'payment_mode' => $request->payment_mode,
            'collected_by' => auth()->id()
        ]);

        return redirect()->route('admin.billing.index')
            ->with('success', 'Payment Recorded Successfully');
    }

    // 🔹 Show (Invoice)
    public function show($id)
    {
        $billing = ReceptionistBilling::with('patient')->findOrFail($id);
        return view('admin.billing.show', compact('billing'));
    }

    // 🔹 PDF Receipt
    public function receipt($id)
    {
        $billing = ReceptionistBilling::with('patient')->findOrFail($id);

        $pdf = PDF::loadView('admin.billing.receipt', compact('billing'));

        return $pdf->download('receipt_' . $billing->receipt_no . '.pdf');
    }
}