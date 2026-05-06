<?php

namespace App\Http\Controllers\Admin\Accountant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountantPayment;
use App\Models\IpdBill;
use Illuminate\Support\Facades\DB;

class AccountantPaymentController extends Controller
{    
    private function paymentBillPayload(IpdBill $bill)
    {
        $bill->loadMissing(['patient', 'ipd', 'payments']);

        return [
            'id' => $bill->id,
            'bill_no' => $bill->bill_no,
            'patient_id' => $bill->patient_id,
            'patient_name' => trim(($bill->patient->first_name ?? '') . ' ' . ($bill->patient->last_name ?? '')),
            'advance_amount' => $bill->ipd->advance_amount ?? 0,
            'payable_amount' => (float) $bill->payable_amount,
            'paid_amount' => (float) $bill->paid_amount,
            'due_amount' => (float) $bill->due_amount,
            'payment_status' => $bill->payment_status,
        ];
    }

    private function paymentHistoryPayload($payments)
    {
        return $payments->map(function ($payment) {
            return [
                'id' => $payment->id,
                'amount' => (float) $payment->amount,
                'payment_mode' => $payment->payment_mode,
                'transaction_id' => $payment->transaction_id,
                'created_at' => optional($payment->created_at)->toDateTimeString(),
                'created_at_formatted' => optional($payment->created_at)->format('d M Y, h:i A'),
            ];
        })->values();
    }

    public function create($bill_id)
    {
        $bill = IpdBill::with(['patient','payments'])->findOrFail($bill_id);

        return view('admin.Accountant.Payment.create', compact('bill'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bill_id' => 'required',
            'amount' => 'required|numeric|min:1',
            'payment_mode' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $bill = IpdBill::findOrFail($request->bill_id);

            //  Calculate current paid
            $totalPaid = AccountantPayment::where('bill_id', $bill->id)->sum('amount');

            //  Prevent overpayment
            if (($totalPaid + $request->amount) > $bill->payable_amount) {
                return back()->with('error', 'Payment exceeds bill amount');
            }

            //  Create Payment
            AccountantPayment::create([
                'bill_id' => $bill->id,
                'patient_id' => $bill->patient_id,
                'amount' => $request->amount,
                'payment_mode' => $request->payment_mode,
                'transaction_id' => $request->transaction_id,
                'created_by' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('admin.accountant.payment.create', $bill->id)->with('success', 'Payment recorded successfully');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function receipt($id)
    {
        $payment = AccountantPayment::with([
            'bill.patient',
            'bill'
        ])->findOrFail($id);

        return view('admin.Accountant.Payment.receipt', compact('payment'));
    }


    //Api Methods
    public function apiCreate($bill_id)
    {
        $bill = IpdBill::with(['patient', 'ipd', 'payments'])->findOrFail($bill_id);

        return response()->json([
            'status' => true,
            'data' => [
                'bill' => $this->paymentBillPayload($bill),
                'payments' => $this->paymentHistoryPayload($bill->payments),
            ],
        ]);
    }

    public function apiStore(Request $request)
    {
        $request->validate([
            'bill_id' => 'required',
            'amount' => 'required|numeric|min:1',
            'payment_mode' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $bill = IpdBill::with('payments')->findOrFail($request->bill_id);
            $totalPaid = AccountantPayment::where('bill_id', $bill->id)->sum('amount');

            if (($totalPaid + (float) $request->amount) > (float) $bill->payable_amount) {
                return response()->json([
                    'status' => false,
                    'message' => 'Payment exceeds bill amount',
                ], 422);
            }

            $payment = AccountantPayment::create([
                'bill_id' => $bill->id,
                'patient_id' => $bill->patient_id,
                'amount' => $request->amount,
                'payment_mode' => $request->payment_mode,
                'transaction_id' => $request->transaction_id,
                'created_by' => auth()->id() ?? $request->created_by ?? '00000000-0000-0000-0000-000000000000',
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Payment recorded successfully',
                'payment_id' => $payment->id,
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function apiReceipt($id)
    {
        $payment = AccountantPayment::with(['bill.patient', 'bill.payments'])->findOrFail($id);
        $bill = $payment->bill;

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $payment->id,
                'bill_id' => $payment->bill_id,
                'bill_no' => $bill->bill_no,
                'patient_name' => trim(($bill->patient->first_name ?? '') . ' ' . ($bill->patient->last_name ?? '')),
                'amount' => (float) $payment->amount,
                'payment_mode' => $payment->payment_mode,
                'transaction_id' => $payment->transaction_id,
                'created_at' => optional($payment->created_at)->toDateTimeString(),
                'created_at_formatted' => optional($payment->created_at)->format('d M Y, h:i A'),
                'total_bill' => (float) $bill->payable_amount,
                'total_paid' => (float) $bill->paid_amount,
                'remaining_due' => (float) $bill->due_amount,
            ],
        ]);
    }
}
