<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\FinancialReconciliation;
use App\Models\BankVerification;
use App\Models\DigitalPayment;
use App\Models\FinancialDiscrepancy;

class ReconciliationReportController extends Controller
{
    /**
     * Reports Dashboard
     */
    public function index()
    {
        return view(
            'admin.accountant.reconciliation_reports.index'
        );
    }

    /**
     * Daily Reconciliation Report
     */
    public function dailyReport()
    {
        $totalDiscrepancy =
            FinancialDiscrepancy::sum(
                'difference_amount'
            );
        $totalCash =
            FinancialReconciliation::sum(
                'total_cash'
            );

        $totalBankDeposits =
            FinancialReconciliation::sum(
                'total_bank_deposit'
            );

        $totalDigitalPayments =
            FinancialReconciliation::sum(
                'total_digital'
            );

        $totalReconciled =
            FinancialReconciliation::where(
                'status',
                'Matched'
            )->sum('total_bank_deposit');

        FinancialReconciliation::where(
            'status',
            'Mismatch'
        )->sum('difference_amount');

        return view(
            'admin.accountant.reconciliation_reports.daily_report',
            compact(
                'totalCash',
                'totalBankDeposits',
                'totalDigitalPayments',
                'totalReconciled',
                'totalDiscrepancy'
            )
        );
    }

    /**
     * Bank Verification Report
     */
    public function bankReport()
    {
        $verifications =
            BankVerification::latest()->get();

        $verified =
            BankVerification::where(
                'verification_status',
                'Verified'
            )->count();

        $pending =
            BankVerification::where(
                'verification_status',
                'Pending'
            )->count();

        return view(
            'admin.accountant.reconciliation_reports.bank_report',
            compact(
                'verifications',
                'verified',
                'pending'
            )
        );
    }

    /**
     * Digital Payment Report
     */
    public function digitalPaymentReport()
    {
        $payments =
            DigitalPayment::latest()->get();

        $success =
            DigitalPayment::where(
                'settlement_status',
                'Settled'
            )->count();

        $failed =
            DigitalPayment::where(
                'settlement_status',
                'Failed'
            )->count();

        $pending =
            DigitalPayment::where(
                'settlement_status',
                'Pending'
            )->count();

        return view(
            'admin.accountant.reconciliation_reports.digital_payment_report',
            compact(
                'payments',
                'success',
                'failed',
                'pending'
            )
        );
    }

    /**
     * Discrepancy Report
     */
    public function discrepancyReport()
    {
        $discrepancies =
            FinancialDiscrepancy::latest()
                ->get();

        return view(
            'admin.accountant.reconciliation_reports.discrepancy_report',
            compact('discrepancies')
        );
    }

    public function apiIndex()
    {
        return response()->json([
            'status' => true,
            'message' => 'Reconciliation Reports API'
        ]);
    }

    public function apiDailyReport()
    {
        $totalDiscrepancy =
            FinancialDiscrepancy::sum(
                'difference_amount'
            );

        $totalCash =
            FinancialReconciliation::sum(
                'total_cash'
            );

        $totalBankDeposits =
            FinancialReconciliation::sum(
                'total_bank_deposit'
            );

        $totalDigitalPayments =
            FinancialReconciliation::sum(
                'total_digital'
            );

        $totalReconciled =
            FinancialReconciliation::where(
                'status',
                'Matched'
            )->sum('total_bank_deposit');

        return response()->json([
            'status' => true,
            'data' => [

                'total_cash' =>
                    $totalCash,

                'total_bank_deposits' =>
                    $totalBankDeposits,

                'total_digital_payments' =>
                    $totalDigitalPayments,

                'total_reconciled' =>
                    $totalReconciled,

                'total_discrepancy' =>
                    $totalDiscrepancy,
            ]
        ]);
    }

    public function apiBankReport()
    {
        $verifications =
            BankVerification::with(
                'financialReconciliation'
            )->latest()->get();

        $verified =
            BankVerification::where(
                'verification_status',
                'Verified'
            )->count();

        $pending =
            BankVerification::where(
                'verification_status',
                'Pending'
            )->count();

        return response()->json([
            'status' => true,
            'summary' => [

                'verified' =>
                    $verified,

                'pending' =>
                    $pending,
            ],

            'data' => $verifications
        ]);
    }

    public function apiDigitalPaymentReport()
    {
        $payments =
            DigitalPayment::with(
                'financialReconciliation'
            )->latest()->get();

        $success =
            DigitalPayment::where(
                'settlement_status',
                'Settled'
            )->count();

        $failed =
            DigitalPayment::where(
                'settlement_status',
                'Failed'
            )->count();

        $pending =
            DigitalPayment::where(
                'settlement_status',
                'Pending'
            )->count();

        return response()->json([
            'status' => true,

            'summary' => [

                'settled' =>
                    $success,

                'failed' =>
                    $failed,

                'pending' =>
                    $pending,
            ],

            'data' => $payments
        ]);
    }
    public function apiDiscrepancyReport()
    {
        $discrepancies =
            FinancialDiscrepancy::latest()
                ->get();

        $open =
            FinancialDiscrepancy::where(
                'status',
                'Open'
            )->count();

        $resolved =
            FinancialDiscrepancy::where(
                'status',
                'Resolved'
            )->count();

        return response()->json([
            'status' => true,

            'summary' => [

                'open' =>
                    $open,

                'resolved' =>
                    $resolved,
            ],

            'data' => $discrepancies
        ]);
    }
}