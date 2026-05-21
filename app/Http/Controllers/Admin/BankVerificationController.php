<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BankVerification;
use App\Models\FinancialReconciliation;

class BankVerificationController extends Controller
{
    /**
     * List all bank verifications
     */
    public function index()
    {
        $verifications = BankVerification::with('financialReconciliation')
            ->latest()
            ->get();

        return view(
            'admin.accountant.bank_verification.index',
            compact('verifications')
        );
    }

    public function search(Request $request)
    {
        $query = BankVerification::with('financialReconciliation');

        if ($request->has('bank_name') && $request->bank_name) {
            $query->where('bank_name', 'like', '%' . $request->bank_name . '%');
        }

        if ($request->has('verification_status') && $request->verification_status) {
            $query->where('verification_status', $request->verification_status);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('deposit_date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('deposit_date', '<=', $request->date_to);
        }

        $verifications = $query->latest()->get();

        return view(
            'admin.accountant.bank_verification.index',
            compact('verifications')
        );
    }

    /**
     * Create page
     */
    public function create()
    {
        $reconciliations = FinancialReconciliation::latest()->get();

        return view(
            'admin.accountant.bank_verification.create',
            compact('reconciliations')
        );
    }

    /**
     * Store verification
     */
    public function store(Request $request)
    {
        $request->validate([

            'financial_reconciliation_id' => 'required|exists:financial_reconciliations,id',

            'bank_name' => 'required|string|max:255',

            'deposit_amount' => 'required|numeric|min:0',

            'deposit_date' => 'required|date',

            'reference_number' => 'nullable|string|max:255',

            'verified_by' => 'nullable|string|max:255',

            'remarks' => 'nullable|string',
        ]);

        // Get reconciliation
        $reconciliation = FinancialReconciliation::findOrFail(
            $request->financial_reconciliation_id
        );

        // Expected amount
        $expected =
            $reconciliation->total_cash +
            $reconciliation->total_digital;

        // Verification logic
        $verificationStatus =
            $request->deposit_amount == $expected
            ? 'Verified'
            : 'Mismatch';

        BankVerification::create([

            'financial_reconciliation_id' =>
                $request->financial_reconciliation_id,

            'bank_name' => $request->bank_name,

            'deposit_amount' => $request->deposit_amount,

            'deposit_date' => $request->deposit_date,

            'reference_number' => $request->reference_number,

            'verification_status' => $verificationStatus,

            'verified_by' => $request->verified_by,

            'remarks' => $request->remarks,
        ]);

        // UPDATE TOTAL BANK DEPOSIT

        $totalDeposit = BankVerification::where(
            'financial_reconciliation_id',
            $request->financial_reconciliation_id
        )->sum('deposit_amount');

        $reconciliation->total_bank_deposit = $totalDeposit;

        // RECALCULATE DIFFERENCE

        $expected =
            $reconciliation->total_cash +
            $reconciliation->total_digital;

        $difference =
            $expected -
            $totalDeposit;

        $reconciliation->difference_amount = abs($difference);

        $reconciliation->status =
            $difference == 0
            ? 'Matched'
            : 'Mismatch';

        $reconciliation->save();

        return redirect()
            ->route('admin.bank-verification.index')
            ->with(
                'success',
                'Verification updated successfully'
            );
    }

    /**
     * View single verification
     */
    public function show($id)
    {
        $verification = BankVerification::with('financialReconciliation')
            ->findOrFail($id);

        return view(
            'admin.accountant.bank_verification.view',
            compact('verification')
        );
    }

    /**
     * Edit Page
     */
    public function edit($id)
    {
        $verification = BankVerification::findOrFail($id);

        $reconciliations = FinancialReconciliation::latest()->get();

        return view(
            'admin.accountant.bank_verification.edit',
            compact(
                'verification',
                'reconciliations'
            )
        );
    }

    /**
     * Update Verification
     */
    public function update(Request $request, $id)
    {
        $request->validate([

            'financial_reconciliation_id' =>
                'required|exists:financial_reconciliations,id',

            'bank_name' =>
                'required|string|max:255',

            'deposit_amount' =>
                'required|numeric|min:0',

            'deposit_date' =>
                'required|date',

            'reference_number' =>
                'nullable|string|max:255',

            'verified_by' =>
                'nullable|string|max:255',

            'remarks' =>
                'nullable|string',
        ]);

        $verification = BankVerification::findOrFail($id);

        // MATCH CHECK
        $reconciliation = FinancialReconciliation::findOrFail(
            $request->financial_reconciliation_id
        );

        $expected =
            $reconciliation->total_cash +
            $reconciliation->total_digital;

        $status =
            $request->deposit_amount == $expected
            ? 'Verified'
            : 'Mismatch';

        $verification->update([

            'financial_reconciliation_id' =>
                $request->financial_reconciliation_id,

            'bank_name' =>
                $request->bank_name,

            'deposit_amount' =>
                $request->deposit_amount,

            'deposit_date' =>
                $request->deposit_date,

            'reference_number' =>
                $request->reference_number,

            'verification_status' =>
                $status,

            'verified_by' =>
                $request->verified_by,

            'remarks' =>
                $request->remarks,
        ]);

        // UPDATE TOTAL BANK DEPOSIT

        $totalDeposit = BankVerification::where(
            'financial_reconciliation_id',
            $request->financial_reconciliation_id
        )->sum('deposit_amount');

        $reconciliation->total_bank_deposit = $totalDeposit;

        // RECALCULATE DIFFERENCE

        $expected =
            $reconciliation->total_cash +
            $reconciliation->total_digital;

        $difference =
            $expected -
            $totalDeposit;

        $reconciliation->difference_amount = abs($difference);

        $reconciliation->status =
            $difference == 0
            ? 'Matched'
            : 'Mismatch';

        $reconciliation->save();

        return redirect()
            ->route('admin.bank-verification.index')
            ->with(
                'success',
                'Verification updated successfully'
            );
    }

    /**
     * Soft Delete
     */
    public function destroy($id)
    {
        $verification = BankVerification::findOrFail($id);

        $verification->delete();

        return back()->with(
            'success',
            'Verification deleted successfully'
        );
    }

    /**
     * Deleted Records
     */
    public function deleted()
    {
        $verifications = BankVerification::onlyTrashed()
            ->latest()
            ->get();

        return view(
            'admin.accountant.bank_verification.deleted',
            compact('verifications')
        );
    }

    /**
     * Restore
     */
    public function restore($id)
    {
        $verification = BankVerification::withTrashed()
            ->findOrFail($id);

        $verification->restore();

        return back()->with(
            'success',
            'Verification restored successfully'
        );
    }

    /**
     * Permanent Delete
     */
    public function forceDelete($id)
    {
        $verification = BankVerification::withTrashed()
            ->findOrFail($id);

        $verification->forceDelete();

        return back()->with(
            'success',
            'Verification permanently deleted'
        );
    }

    public function apiIndex()
    {
        $verifications = BankVerification::with('financialReconciliation')
            ->latest()
            ->get();

        return response()->json(
            compact('verifications')
        );
    }

    public function apiShow($id)
    {
        $verification = BankVerification::with('financialReconciliation')
            ->findOrFail($id);

        return response()->json(
            compact('verification')
        );
    }

    public function apiStore(Request $request)
    {
        $request->validate([

            'financial_reconciliation_id' =>
                'required|exists:financial_reconciliations,id',

            'bank_name' =>
                'required|string|max:255',

            'deposit_amount' =>
                'required|numeric|min:0',

            'deposit_date' =>
                'required|date',

            'reference_number' =>
                'nullable|string|max:255',

            'verified_by' =>
                'nullable|string|max:255',

            'remarks' =>
                'nullable|string',
        ]);

        $reconciliation = FinancialReconciliation::findOrFail(
            $request->financial_reconciliation_id
        );

        $expected =
            $reconciliation->total_cash +
            $reconciliation->total_digital;

        $status =
            $request->deposit_amount == $expected
            ? 'Verified'
            : 'Mismatch';

        $verification = BankVerification::create([

            'financial_reconciliation_id' =>
                $request->financial_reconciliation_id,

            'bank_name' =>
                $request->bank_name,

            'deposit_amount' =>
                $request->deposit_amount,

            'deposit_date' =>
                $request->deposit_date,

            'reference_number' =>
                $request->reference_number,

            'verification_status' =>
                $status,

            'verified_by' =>
                $request->verified_by,

            'remarks' =>
                $request->remarks,
        ]);

        $totalDeposit = BankVerification::where(
            'financial_reconciliation_id',
            $request->financial_reconciliation_id
        )->sum('deposit_amount');

        $reconciliation->total_bank_deposit =
            $totalDeposit;

        $difference =
            (
                $reconciliation->total_cash +
                $reconciliation->total_digital
            ) - $totalDeposit;

        $reconciliation->difference_amount =
            abs($difference);

        $reconciliation->status =
            $difference == 0
            ? 'Matched'
            : 'Mismatch';

        $reconciliation->save();

        return response()->json([
            'status' => true,
            'message' => 'Verification created successfully',
            'data' => $verification
        ]);
    }

    public function apiUpdate(Request $request, $id)
    {
        $verification = BankVerification::findOrFail($id);

        $request->validate([

            'financial_reconciliation_id' =>
                'required|exists:financial_reconciliations,id',

            'bank_name' =>
                'required|string|max:255',

            'deposit_amount' =>
                'required|numeric|min:0',

            'deposit_date' =>
                'required|date',
        ]);

        $reconciliation = FinancialReconciliation::findOrFail(
            $request->financial_reconciliation_id
        );

        $expected =
            $reconciliation->total_cash +
            $reconciliation->total_digital;

        $status =
            $request->deposit_amount == $expected
            ? 'Verified'
            : 'Mismatch';

        $verification->update([

            'financial_reconciliation_id' =>
                $request->financial_reconciliation_id,

            'bank_name' =>
                $request->bank_name,

            'deposit_amount' =>
                $request->deposit_amount,

            'deposit_date' =>
                $request->deposit_date,

            'reference_number' =>
                $request->reference_number,

            'verification_status' =>
                $status,

            'verified_by' =>
                $request->verified_by,

            'remarks' =>
                $request->remarks,
        ]);

        $totalDeposit = BankVerification::where(
            'financial_reconciliation_id',
            $request->financial_reconciliation_id
        )->sum('deposit_amount');

        $reconciliation->total_bank_deposit =
            $totalDeposit;

        $difference =
            (
                $reconciliation->total_cash +
                $reconciliation->total_digital
            ) - $totalDeposit;

        $reconciliation->difference_amount =
            abs($difference);

        $reconciliation->status =
            $difference == 0
            ? 'Matched'
            : 'Mismatch';

        $reconciliation->save();

        return response()->json([
            'status' => true,
            'message' => 'Verification updated successfully'
        ]);
    }

    public function apiDelete($id)
    {
        $verification = BankVerification::findOrFail($id);

        $verification->delete();

        return response()->json([
            'status' => true,
            'message' => 'Verification deleted successfully'
        ]);
    }
    public function apiDeleted()
    {
        $verifications = BankVerification::onlyTrashed()
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'data' => $verifications
        ]);
    }
    public function apiRestore($id)
    {
        $verification = BankVerification::withTrashed()
            ->findOrFail($id);

        $verification->restore();

        return response()->json([
            'status' => true,
            'message' => 'Verification restored successfully'
        ]);
    }


    public function apiForceDelete($id)
    {
        $verification = BankVerification::withTrashed()
            ->findOrFail($id);

        $verification->forceDelete();

        return response()->json([
            'status' => true,
            'message' => 'Verification permanently deleted'
        ]);
    }
    public function apiSearch(Request $request)
    {
        $query = BankVerification::with('financialReconciliation');

        if ($request->search) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'bank_name',
                    'like',
                    '%' . $search . '%'
                )

                    ->orWhere(
                        'verified_by',
                        'like',
                        '%' . $search . '%'
                    )

                    ->orWhere(
                        'verification_status',
                        'like',
                        '%' . $search . '%'
                    )

                    ->orWhereHas(
                        'financialReconciliation',
                        function ($subQ) use ($search) {

                            $subQ->where(
                                'id',
                                'like',
                                '%' . $search . '%'
                            );
                        }
                    );
            });
        }

        if ($request->verification_status) {
            $query->where(
                'verification_status',
                $request->verification_status
            );
        }

        if ($request->date_from) {
            $query->whereDate(
                'deposit_date',
                '>=',
                $request->date_from
            );
        }

        if ($request->date_to) {
            $query->whereDate(
                'deposit_date',
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