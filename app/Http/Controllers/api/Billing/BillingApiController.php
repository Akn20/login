<?php

namespace App\Http\Controllers\Api\Billing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReceptionistBilling;
use Illuminate\Support\Str;

class BillingApiController extends Controller
{
    // 🔹 List all billing
    public function index()
    {
        $data = ReceptionistBilling::with('patient')
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    // 🔹 Store billing
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'amount' => 'required|numeric',
            'payment_mode' => 'required'
        ]);

        $billing = ReceptionistBilling::create([
            'id' => (string) Str::uuid(),
            'receipt_no' => 'RCPT-' . time(),
            'patient_id' => $request->patient_id,
            'visit_id' => $request->visit_id,
            'amount' => $request->amount,
            'payment_mode' => $request->payment_mode,
            'collected_by' => auth()->id() ?? null
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Billing Created',
            'data' => $billing
        ]);
    }

    // 🔹 Show single billing
    public function show($id)
    {
        $billing = ReceptionistBilling::with('patient')->find($id);

        if (!$billing) {
            return response()->json([
                'status' => false,
                'message' => 'Not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $billing
        ]);
    }

    // 🔹 Delete billing
    public function destroy($id)
    {
        $billing = ReceptionistBilling::find($id);

        if (!$billing) {
            return response()->json([
                'status' => false,
                'message' => 'Not found'
            ], 404);
        }

        $billing->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully'
        ]);
    }
}