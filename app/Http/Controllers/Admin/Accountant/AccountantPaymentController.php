<?php

namespace App\Http\Controllers\Admin\Accountant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountantPayment;
use App\Models\IpdBill;
use Illuminate\Support\Facades\DB;

class AccountantPaymentController extends Controller
{    
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
}
