<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinancialReconciliation;
use App\Models\FinancialDiscrepancy;

class FinancialReconciliationController extends Controller
{
    /**
     * Display reconciliation list
     */
    public function index(Request $request)
    {
        $query = FinancialReconciliation::query();

        if ($request->filled('search')) {
            $date = \Carbon\Carbon::createFromFormat(
                'Y-m-d',
                $request->search
            )->format('Y-m-d');

            $query->whereDate('reconciliation_date', $date);
        }

        $reconciliations = $query->latest()->get();

        return view(
            'admin.accountant.financial_reconciliation.index',
            compact('reconciliations')
        );
    }

    /**
     * Show create page
     */
    public function create()
    {
        return view('admin.accountant.financial_reconciliation.create');
    }

    public function search(Request $request)
    {
        $query = FinancialReconciliation::query();

        if ($request->filled('search')) {

            $date = \Carbon\Carbon::createFromFormat(
                'Y-m-d',
                $request->search
            )->format('Y-m-d');

            $query->whereDate(
                'reconciliation_date',
                $date
            );
        }

        $reconciliations =
            $query->latest()->get();

        return view(
            'admin.accountant.financial_reconciliation.index',
            compact('reconciliations')
        );
    }


    public function edit($id)
    {
        $reconciliation = FinancialReconciliation::findOrFail($id);

        return view(
            'admin.accountant.financial_reconciliation.edit',
            compact('reconciliation')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'reconciliation_date' => 'required|date',
            'total_cash' => 'required|numeric|min:0',
            'total_digital' => 'nullable|numeric|min:0',
            'total_bank_deposit' => 'nullable|numeric|min:0',
            'bank_name' => 'nullable|string|max:255',
            'deposit_reference' => 'nullable|string|max:255',
            'verification_status' => 'nullable|string',
            'payment_gateway' => 'nullable|string|max:255',
            'gateway_reference' => 'nullable|string|max:255',
            'digital_payment_status' => 'nullable|string',
            'remarks' => 'nullable|string'
        ]);

        $reconciliation = FinancialReconciliation::findOrFail($id);

        $totalDigital =
            $request->filled('total_digital')
            ? $request->total_digital
            : 0;

        $totalBankDeposit =
            $request->filled('total_bank_deposit')
            ? $request->total_bank_deposit
            : 0;

        $difference =
            ($request->total_cash + $totalDigital)
            - $totalBankDeposit;

        $status = $difference == 0
            ? 'Matched'
            : 'Mismatch';

        $reconciliation->update([
            'reconciliation_date' => $request->reconciliation_date,
            'total_cash' => $request->total_cash,
            'total_digital' => $totalDigital,
            'total_bank_deposit' => $totalBankDeposit,
            'difference_amount' => $difference,
            'status' => $status,
            'bank_name' => $request->bank_name,
            'deposit_reference' => $request->deposit_reference,
            'verification_status' => $request->verification_status,
            'payment_gateway' => $request->payment_gateway,
            'gateway_reference' => $request->gateway_reference,
            'digital_payment_status' => $request->digital_payment_status,
            'remarks' => $request->remarks,
        ]);

        // DELETE OLD DISCREPANCIES
        FinancialDiscrepancy::where(
            'financial_reconciliation_id',
            $reconciliation->id
        )->delete();

        // CREATE NEW DISCREPANCY IF MISMATCH EXISTS
        if ($difference != 0) {

            FinancialDiscrepancy::create([

                'financial_reconciliation_id' =>
                    $reconciliation->id,

                'issue_type' =>
                    'Amount Mismatch',

                'expected_amount' =>
                    $request->total_cash +
                    $totalDigital,

                'actual_amount' =>
                    $totalBankDeposit,

                'difference_amount' =>
                    $difference,

                'status' =>
                    'Open',

                'remarks' =>
                    'Automatically detected during reconciliation update',
            ]);
        }

        return redirect()
            ->route('admin.financial-reconciliation.index')
            ->with('success', 'Reconciliation updated successfully');
    }

    /**
     * Store reconciliation
     */
    public function store(Request $request)
    {
        $request->validate([
            'reconciliation_date' => 'required|date',
            'total_cash' => 'required|numeric|min:0',
            'total_digital' => 'nullable|numeric|min:0',
            'total_bank_deposit' => 'nullable|numeric|min:0',
            'bank_name' => 'nullable|string|max:255',

            'deposit_reference' => 'nullable|string|max:255',

            'verification_status' => 'nullable|string',

            'payment_gateway' => 'nullable|string|max:255',

            'gateway_reference' => 'nullable|string|max:255',

            'digital_payment_status' => 'nullable|string',
            'remarks' => 'nullable|string'
        ]);

        $totalDigital =
            $request->filled('total_digital')
            ? $request->total_digital
            : 0;

        $totalBankDeposit = $request->filled('total_bank_deposit')
            ? $request->total_bank_deposit
            : 0;


        // Calculate difference
        $difference = ($request->total_cash + $totalDigital) - $totalBankDeposit;

        // Determine status
        $status = $difference == 0
            ? 'Matched'
            : 'Mismatch';



        $reconciliation = FinancialReconciliation::create([
            'reconciliation_date' => $request->reconciliation_date,
            'total_cash' => $request->total_cash,
            'total_digital' => $totalDigital,
            'total_bank_deposit' => $totalBankDeposit,
            'difference_amount' => $difference,
            'status' => $status,
            'remarks' => $request->remarks,
            'bank_name' => $request->bank_name,
            'deposit_reference' => $request->deposit_reference,
            'verification_status' => $request->verification_status,
            'payment_gateway' => $request->payment_gateway,
            'gateway_reference' => $request->gateway_reference,
            'digital_payment_status' => $request->digital_payment_status,
        ]);

        // AUTO CREATE DISCREPANCY
        if ($difference != 0) {

            FinancialDiscrepancy::create([

                'financial_reconciliation_id' =>
                    $reconciliation->id,

                'issue_type' =>
                    'Amount Mismatch',

                'expected_amount' =>
                    $request->total_cash +
                    $totalDigital,

                'actual_amount' =>
                    $totalBankDeposit,

                'difference_amount' =>
                    $difference,

                'status' =>
                    'Open',

                'remarks' =>
                    'Automatically detected during reconciliation',
            ]);
        }

        return redirect()
            ->route('admin.financial-reconciliation.index')
            ->with('success', 'Financial reconciliation created successfully');
    }

    /**
     * Show single reconciliation
     */
    public function show($id)
    {
        $reconciliation = FinancialReconciliation::findOrFail($id);

        return view(
            'admin.accountant.financial_reconciliation.view',
            compact('reconciliation')
        );
    }

    public function destroy($id)
    {
        $reconciliation = FinancialReconciliation::findOrFail($id);

        $reconciliation->delete();

        return back()->with(
            'success',
            'Reconciliation moved to deleted list'
        );
    }
    public function deleted()
    {
        $reconciliations = FinancialReconciliation::onlyTrashed()
            ->latest()
            ->get();

        return view(
            'admin.accountant.financial_reconciliation.deleted',
            compact('reconciliations')
        );
    }
    public function restore($id)
    {
        $reconciliation = FinancialReconciliation::withTrashed()
            ->findOrFail($id);

        $reconciliation->restore();

        return back()->with(
            'success',
            'Reconciliation restored successfully'
        );
    }
    public function forceDelete($id)
    {
        $reconciliation = FinancialReconciliation::withTrashed()
            ->findOrFail($id);

        $reconciliation->forceDelete();

        return back()->with(
            'success',
            'Reconciliation permanently deleted'
        );
    }

    public function apiIndex()
    {
        $reconciliations = FinancialReconciliation::latest()
            ->get();

        return response()->json([
            'status' => true,
            'data' => $reconciliations
        ]);
    }

    public function apiShow($id)
    {
        $reconciliation = FinancialReconciliation::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $reconciliation
        ]);
    }

    public function apiStore(Request $request)
    {
        $request->validate([
            'reconciliation_date' => 'required|date',
            'total_cash' => 'required|numeric|min:0',
            'total_digital' => 'nullable|numeric|min:0',
            'total_bank_deposit' => 'nullable|numeric|min:0',
            'verification_status' => 'nullable|string',
            'digital_payment_status' => 'nullable|string',
        ]);

        $totalDigital = $request->filled('total_digital') ? $request->total_digital : 0;
        $totalBankDeposit = $request->filled('total_bank_deposit') ? $request->total_bank_deposit : 0;

        $difference =
            ($request->total_cash + $totalDigital)
            - $totalBankDeposit;

        $status =
            $difference == 0
            ? 'Matched'
            : 'Mismatch';

        $reconciliation = FinancialReconciliation::create([

            'reconciliation_date' =>
                $request->reconciliation_date,

            'total_cash' =>
                $request->total_cash,

            'total_digital' =>
                $totalDigital,

            'total_bank_deposit' =>
                $totalBankDeposit,

            'difference_amount' =>
                $difference,

            'status' =>
                $status,

            'remarks' =>
                $request->remarks,

            'bank_name' =>
                $request->bank_name,

            'deposit_reference' =>
                $request->deposit_reference,

            'verification_status' =>
                $request->verification_status,

            'payment_gateway' =>
                $request->payment_gateway,

            'gateway_reference' =>
                $request->gateway_reference,

            'digital_payment_status' =>
                $request->digital_payment_status,
        ]);

        // AUTO DISCREPANCY
        if ($difference != 0) {

            FinancialDiscrepancy::create([

                'financial_reconciliation_id' =>
                    $reconciliation->id,

                'issue_type' =>
                    'Amount Mismatch',

                'expected_amount' =>
                    $request->total_cash +
                    $totalDigital,

                'actual_amount' =>
                    $totalBankDeposit,

                'difference_amount' =>
                    $difference,

                'status' =>
                    'Open',

                'remarks' =>
                    'Automatically detected during reconciliation',
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Financial reconciliation created successfully',
            'data' => $reconciliation
        ]);
    }

    public function apiUpdate(Request $request, $id)
    {
        $reconciliation = FinancialReconciliation::findOrFail($id);

        $request->validate([
            'reconciliation_date' => 'required|date',
            'total_cash' => 'required|numeric|min:0',
            'total_digital' => 'nullable|numeric|min:0',
            'total_bank_deposit' => 'nullable|numeric|min:0',
            'verification_status' => 'nullable|string',
            'digital_payment_status' => 'nullable|string',
        ]);

        $totalDigital = $request->filled('total_digital') ? $request->total_digital : 0;
        $totalBankDeposit = $request->filled('total_bank_deposit') ? $request->total_bank_deposit : 0;

        $difference =
            ($request->total_cash + $totalDigital)
            - $totalBankDeposit;

        $status =
            $difference == 0
            ? 'Matched'
            : 'Mismatch';

        $reconciliation->update([

            'reconciliation_date' =>
                $request->reconciliation_date,

            'total_cash' =>
                $request->total_cash,

            'total_digital' =>
                $totalDigital,

            'total_bank_deposit' =>
                $totalBankDeposit,

            'difference_amount' =>
                $difference,

            'status' =>
                $status,

            'remarks' =>
                $request->remarks,

            'bank_name' =>
                $request->bank_name,

            'deposit_reference' =>
                $request->deposit_reference,

            'verification_status' =>
                $request->verification_status,

            'payment_gateway' =>
                $request->payment_gateway,

            'gateway_reference' =>
                $request->gateway_reference,

            'digital_payment_status' =>
                $request->digital_payment_status,
        ]);

        // REMOVE OLD DISCREPANCIES
        FinancialDiscrepancy::where(
            'financial_reconciliation_id',
            $reconciliation->id
        )->delete();

        // CREATE NEW DISCREPANCY
        if ($difference != 0) {

            FinancialDiscrepancy::create([

                'financial_reconciliation_id' =>
                    $reconciliation->id,

                'issue_type' =>
                    'Amount Mismatch',

                'expected_amount' =>
                    $request->total_cash +
                    $totalDigital,

                'actual_amount' =>
                    $totalBankDeposit,

                'difference_amount' =>
                    $difference,

                'status' =>
                    'Open',

                'remarks' =>
                    'Automatically detected during reconciliation update',
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Financial reconciliation updated successfully'
        ]);
    }

    public function apiDelete($id)
    {
        $reconciliation = FinancialReconciliation::findOrFail($id);

        $reconciliation->delete();

        return response()->json([
            'status' => true,
            'message' => 'Reconciliation deleted successfully'
        ]);
    }
    public function apiDeleted()
    {
        $reconciliations = FinancialReconciliation::onlyTrashed()
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'data' => $reconciliations
        ]);
    }

    public function apiRestore($id)
    {
        $reconciliation = FinancialReconciliation::withTrashed()
            ->findOrFail($id);

        $reconciliation->restore();

        return response()->json([
            'status' => true,
            'message' => 'Reconciliation restored successfully'
        ]);
    }


    public function apiForceDelete($id)
    {
        $reconciliation = FinancialReconciliation::withTrashed()
            ->findOrFail($id);

        $reconciliation->forceDelete();

        return response()->json([
            'status' => true,
            'message' => 'Reconciliation permanently deleted'
        ]);
    }
    public function apiSearch(Request $request)
    {
        $query = FinancialReconciliation::query();

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                // REC ID SEARCH
                $q->where('id', 'like', "%{$search}%")

                    // OTHER SEARCHES
                    ->orWhere('bank_name', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('verification_status', 'like', "%{$search}%")
                    ->orWhere('payment_gateway', 'like', "%{$search}%")
                    ->orWhere('deposit_reference', 'like', "%{$search}%")
                    ->orWhere('gateway_reference', 'like', "%{$search}%");

                // DATE SEARCH
                // DATE SEARCH
                $q->orWhere(
                    'reconciliation_date',
                    'like',
                    "%{$search}%"
                );
            });
        }

        $reconciliations =
            $query->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $reconciliations
        ]);
    }

}