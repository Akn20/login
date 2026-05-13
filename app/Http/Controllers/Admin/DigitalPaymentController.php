<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DigitalPayment;
use App\Models\FinancialReconciliation;

class DigitalPaymentController extends Controller
{
    /**
     * Index Page
     */
    public function index()
    {
        $payments = DigitalPayment::with('reconciliation')
            ->latest()
            ->get();

        return view(
            'admin.accountant.digital_payment.index',
            compact('payments')
        );
    }

    public function search(Request $request)
    {
        $query = DigitalPayment::with('reconciliation');

        if ($request->has('payment_method') && $request->payment_method) {
            $query->where(
                'payment_method',
                'like',
                '%' . $request->payment_method . '%'
            );
        }

        if ($request->has('payment_gateway') && $request->payment_gateway) {
            $query->where(
                'payment_gateway',
                'like',
                '%' . $request->payment_gateway . '%'
            );
        }

        if ($request->has('matching_status') && $request->matching_status) {
            $query->where(
                'matching_status',
                $request->matching_status
            );
        }

        if ($request->has('settlement_status') && $request->settlement_status) {
            $query->where(
                'settlement_status',
                $request->settlement_status
            );
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate(
                'payment_date',
                '>=',
                $request->date_from
            );
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate(
                'payment_date',
                '<=',
                $request->date_to
            );
        }

        $payments = $query->latest()->get();

        return view(
            'admin.accountant.digital_payment.index',
            compact('payments')
        );
    }

    /**
     * Create Page
     */
    public function create()
    {
        $reconciliations = FinancialReconciliation::latest()
            ->get();

        return view(
            'admin.accountant.digital_payment.create',
            compact('reconciliations')
        );
    }

    /**
     * Store
     */
    public function store(Request $request)
    {
        $request->validate([

            'financial_reconciliation_id' =>
                'required|exists:financial_reconciliations,id',

            'payment_method' =>
                'required|string|max:255',

            'payment_gateway' =>
                'required|string|max:255',

            'payment_amount' =>
                'required|numeric|min:0',

            'payment_date' =>
                'required|date',

            'transaction_reference' =>
                'nullable|string|max:255',

            'remarks' =>
                'nullable|string',
        ]);

        $reconciliation = FinancialReconciliation::findOrFail(
    $request->financial_reconciliation_id
);

// TOTAL EXISTING PAYMENTS
$totalPayments =
    DigitalPayment::where(
        'financial_reconciliation_id',
        $request->financial_reconciliation_id
    )->sum('payment_amount');

// ADD CURRENT PAYMENT
$totalPayments += $request->payment_amount;

// MATCHING STATUS
$matchingStatus =
    $totalPayments == $reconciliation->total_digital
    ? 'Matched'
    : 'Mismatch';

// SETTLEMENT STATUS
$settlementStatus =
    $request->transaction_reference
    ? 'Settled'
    : 'Pending';

        DigitalPayment::create([

            'financial_reconciliation_id' =>
                $request->financial_reconciliation_id,

            'payment_method' =>
                $request->payment_method,

            'payment_gateway' =>
                $request->payment_gateway,

            'payment_amount' =>
                $request->payment_amount,

            'payment_date' =>
                $request->payment_date,

            'transaction_reference' =>
                $request->transaction_reference,

            'matching_status' =>
                $matchingStatus,

            'settlement_status' =>
                $settlementStatus,

            'remarks' =>
                $request->remarks,
        ]);

        return redirect()
            ->route('admin.digital-payment.index')
            ->with(
                'success',
                'Digital payment added successfully'
            );
    }

    /**
     * View
     */
    public function show($id)
    {
        $payment = DigitalPayment::with('reconciliation')
            ->findOrFail($id);

        return view(
            'admin.accountant.digital_payment.view',
            compact('payment')
        );
    }

    /**
     * Edit
     */
    public function edit($id)
    {
        $payment = DigitalPayment::findOrFail($id);

        $reconciliations = FinancialReconciliation::latest()
            ->get();

        return view(
            'admin.accountant.digital_payment.edit',
            compact(
                'payment',
                'reconciliations'
            )
        );
    }

    /**
     * Update
     */
    public function update(Request $request, $id)
    {
        $request->validate([

            'financial_reconciliation_id' =>
                'required|exists:financial_reconciliations,id',

            'payment_method' =>
                'required|string|max:255',

            'payment_gateway' =>
                'required|string|max:255',

            'payment_amount' =>
                'required|numeric|min:0',

            'payment_date' =>
                'required|date',

            'transaction_reference' =>
                'nullable|string|max:255',

            'remarks' =>
                'nullable|string',
        ]);

        $payment = DigitalPayment::findOrFail($id);

        // MATCHING STATUS
       $reconciliation = FinancialReconciliation::findOrFail(
    $request->financial_reconciliation_id
);

// TOTAL PAYMENTS EXCEPT CURRENT
$totalPayments =
    DigitalPayment::where(
        'financial_reconciliation_id',
        $request->financial_reconciliation_id
    )
    ->where('id', '!=', $id)
    ->sum('payment_amount');

// ADD UPDATED AMOUNT
$totalPayments += $request->payment_amount;

// MATCHING STATUS
$matchingStatus =
    $totalPayments == $reconciliation->total_digital
    ? 'Matched'
    : 'Mismatch';

// SETTLEMENT STATUS
$settlementStatus =
    $request->transaction_reference
    ? 'Settled'
    : 'Pending';

        $payment->update([

            'financial_reconciliation_id' =>
                $request->financial_reconciliation_id,

            'payment_method' =>
                $request->payment_method,

            'payment_gateway' =>
                $request->payment_gateway,

            'payment_amount' =>
                $request->payment_amount,

            'payment_date' =>
                $request->payment_date,

            'transaction_reference' =>
                $request->transaction_reference,

            'matching_status' =>
                $matchingStatus,

            'settlement_status' =>
                $settlementStatus,

            'remarks' =>
                $request->remarks,
        ]);

        return redirect()
            ->route('admin.digital-payment.index')
            ->with(
                'success',
                'Digital payment updated successfully'
            );
    }

    /**
     * Delete
     */
    public function destroy($id)
    {
        $payment = DigitalPayment::findOrFail($id);

        $payment->delete();

        return back()->with(
            'success',
            'Digital payment deleted successfully'
        );
    }

    /**
     * Deleted List
     */
    public function deleted()
    {
        $payments = DigitalPayment::onlyTrashed()
            ->latest()
            ->get();

        return view(
            'admin.accountant.digital_payment.deleted',
            compact('payments')
        );
    }

    /**
     * Restore
     */
    public function restore($id)
    {
        $payment = DigitalPayment::withTrashed()
            ->findOrFail($id);

        $payment->restore();

        return back()->with(
            'success',
            'Digital payment restored successfully'
        );
    }

    /**
     * Permanent Delete
     */
    public function forceDelete($id)
    {
        $payment = DigitalPayment::withTrashed()
            ->findOrFail($id);

        $payment->forceDelete();

        return back()->with(
            'success',
            'Digital payment permanently deleted'
        );
    }

    public function apiIndex()
{
    $payments = DigitalPayment::with('reconciliation')
        ->latest()
        ->get();

    return response()->json([
        'status' => true,
        'data' => $payments
    ]);
}
public function apiShow($id)
{
    $payment = DigitalPayment::with('reconciliation')
        ->findOrFail($id);

    return response()->json([
        'status' => true,
        'data' => $payment
    ]);
}
public function apiStore(Request $request)
{
    $request->validate([

        'financial_reconciliation_id' =>
            'required|exists:financial_reconciliations,id',

        'payment_method' =>
            'required|string|max:255',

        'payment_gateway' =>
            'required|string|max:255',

        'payment_amount' =>
            'required|numeric|min:0',

        'payment_date' =>
            'required|date',
    ]);

    $reconciliation = FinancialReconciliation::findOrFail(
        $request->financial_reconciliation_id
    );

    $totalPayments =
        DigitalPayment::where(
            'financial_reconciliation_id',
            $request->financial_reconciliation_id
        )->sum('payment_amount');

    $totalPayments += $request->payment_amount;

    $matchingStatus =
        $totalPayments == $reconciliation->total_digital
        ? 'Matched'
        : 'Mismatch';

    $settlementStatus =
        $request->transaction_reference
        ? 'Settled'
        : 'Pending';

    $payment = DigitalPayment::create([

        'financial_reconciliation_id' =>
            $request->financial_reconciliation_id,

        'payment_method' =>
            $request->payment_method,

        'payment_gateway' =>
            $request->payment_gateway,

        'payment_amount' =>
            $request->payment_amount,

        'payment_date' =>
            $request->payment_date,

        'transaction_reference' =>
            $request->transaction_reference,

        'matching_status' =>
            $matchingStatus,

        'settlement_status' =>
            $settlementStatus,

        'remarks' =>
            $request->remarks,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Digital payment created successfully',
        'data' => $payment
    ]);
}

public function apiUpdate(Request $request, $id)
{
    $payment = DigitalPayment::findOrFail($id);

    $request->validate([

        'financial_reconciliation_id' =>
            'required|exists:financial_reconciliations,id',

        'payment_method' =>
            'required|string|max:255',

        'payment_gateway' =>
            'required|string|max:255',

        'payment_amount' =>
            'required|numeric|min:0',

        'payment_date' =>
            'required|date',
    ]);

    $reconciliation = FinancialReconciliation::findOrFail(
        $request->financial_reconciliation_id
    );

    $totalPayments =
        DigitalPayment::where(
            'financial_reconciliation_id',
            $request->financial_reconciliation_id
        )
        ->where('id', '!=', $id)
        ->sum('payment_amount');

    $totalPayments += $request->payment_amount;

    $matchingStatus =
        $totalPayments == $reconciliation->total_digital
        ? 'Matched'
        : 'Mismatch';

    $settlementStatus =
        $request->transaction_reference
        ? 'Settled'
        : 'Pending';

    $payment->update([

        'financial_reconciliation_id' =>
            $request->financial_reconciliation_id,

        'payment_method' =>
            $request->payment_method,

        'payment_gateway' =>
            $request->payment_gateway,

        'payment_amount' =>
            $request->payment_amount,

        'payment_date' =>
            $request->payment_date,

        'transaction_reference' =>
            $request->transaction_reference,

        'matching_status' =>
            $matchingStatus,

        'settlement_status' =>
            $settlementStatus,

        'remarks' =>
            $request->remarks,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Digital payment updated successfully'
    ]);
}

public function apiDelete($id)
{
    $payment = DigitalPayment::findOrFail($id);

    $payment->delete();

    return response()->json([
        'status' => true,
        'message' => 'Digital payment deleted successfully'
    ]);
}

public function apiDeleted()
{
    $payments = DigitalPayment::onlyTrashed()
        ->latest()
        ->get();

    return response()->json([
        'status' => true,
        'data' => $payments
    ]);
}

public function apiRestore($id)
{
    $payment = DigitalPayment::withTrashed()
        ->findOrFail($id);

    $payment->restore();

    return response()->json([
        'status' => true,
        'message' => 'Digital payment restored successfully'
    ]);
}
public function apiForceDelete($id)
{
    $payment = DigitalPayment::withTrashed()
        ->findOrFail($id);

    $payment->forceDelete();

    return response()->json([
        'status' => true,
        'message' => 'Digital payment permanently deleted'
    ]);
}

public function apiSearch(Request $request)
{
    $query = DigitalPayment::with('reconciliation');

    if ($request->payment_method) {
        $query->where(
            'payment_method',
            'like',
            '%' . $request->payment_method . '%'
        );
    }

    if ($request->payment_gateway) {
        $query->where(
            'payment_gateway',
            'like',
            '%' . $request->payment_gateway . '%'
        );
    }

    if ($request->matching_status) {
        $query->where(
            'matching_status',
            $request->matching_status
        );
    }

    if ($request->settlement_status) {
        $query->where(
            'settlement_status',
            $request->settlement_status
        );
    }

    if ($request->date_from) {
        $query->whereDate(
            'payment_date',
            '>=',
            $request->date_from
        );
    }

    if ($request->date_to) {
        $query->whereDate(
            'payment_date',
            '<=',
            $request->date_to
        );
    }

    return response()->json([
        'status' => true,
        'data' => $query->latest()->get()
    ]);
}

    
}