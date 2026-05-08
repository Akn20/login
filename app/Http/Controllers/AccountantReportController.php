<?php

namespace App\Http\Controllers;

use App\Models\AccountantPayment;
use App\Models\ReceptionistBilling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AccountantReportController extends Controller
{

    public function dailyCollection(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | OPD COLLECTIONS
        |--------------------------------------------------------------------------
        */

        $opdQuery = ReceptionistBilling::leftJoin(
                'patients',
                'receptionist_billing.patient_id',
                '=',
                'patients.id'
            )
            ->select(
                'receptionist_billing.id',
                'receptionist_billing.receipt_no as bill_no',
                'receptionist_billing.amount',
                'receptionist_billing.payment_mode',
                'receptionist_billing.created_at as payment_date',
                DB::raw("'OPD' as type"),
                DB::raw("CONCAT(patients.first_name, ' ', patients.last_name) as patient_name")
            );
            
            if ($request->from_date) {

                $opdQuery->whereDate(
                    'receptionist_billing.created_at',
                    '>=',
                    $request->from_date
                );
            }

            if ($request->to_date) {

                $opdQuery->whereDate(
                    'receptionist_billing.created_at',
                    '<=',
                    $request->to_date
                );
            }

            if ($request->payment_mode) {

                $opdQuery->whereRaw(
                    'LOWER(receptionist_billing.payment_mode) = ?',
                    [strtolower($request->payment_mode)]
                );
            }

        /*
        |--------------------------------------------------------------------------
        | IPD COLLECTIONS
        |--------------------------------------------------------------------------
        */

        $ipdQuery = AccountantPayment::leftJoin(
                'patients',
                'accountant_payments.patient_id',
                '=',
                'patients.id'
            )
            ->leftJoin(
                'ipd_bills',
                'accountant_payments.bill_id',
                '=',
                'ipd_bills.id'
            )
            ->select(
                'accountant_payments.id',
                'ipd_bills.bill_no',
                'accountant_payments.amount',
                'accountant_payments.payment_mode',
                'accountant_payments.payment_date',
                DB::raw("'IPD' as type"),
                DB::raw("CONCAT(patients.first_name, ' ', patients.last_name) as patient_name")
            );
            
            if ($request->from_date) {

                $ipdQuery->whereDate(
                    'accountant_payments.payment_date',
                    '>=',
                    $request->from_date
                );
            }

            if ($request->to_date) {

                $ipdQuery->whereDate(
                    'accountant_payments.payment_date',
                    '<=',
                    $request->to_date
                );
            }

            if ($request->payment_mode) {

                $ipdQuery->whereRaw(
                    'LOWER(accountant_payments.payment_mode) = ?',
                    [strtolower($request->payment_mode)]
                );
            }


            $opdQuery = $opdQuery->toBase();
            $ipdQuery = $ipdQuery->toBase();

        /*
        |--------------------------------------------------------------------------
        | UNION BOTH REPORTS
        |--------------------------------------------------------------------------
        */

        $collections = $opdQuery
            ->unionAll($ipdQuery)
            ->orderBy('payment_date', 'desc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | SUMMARY CARDS
        |--------------------------------------------------------------------------
        */

        $totalCollection = $collections->sum('amount');

        $cashCollection = $collections
            ->filter(fn($item) =>
                strtolower($item->payment_mode) == 'cash'
            )
            ->sum('amount');

        $upiCollection = $collections
            ->filter(fn($item) =>
                strtolower($item->payment_mode) == 'upi'
            )
            ->sum('amount');

        $cardCollection = $collections
            ->filter(fn($item) =>
                strtolower($item->payment_mode) == 'card'
            )
            ->sum('amount');

        return view(
            'admin.accountant.reports.daily_collection',
            compact(
                'collections',
                'totalCollection',
                'cashCollection',
                'upiCollection',
                'cardCollection'
            )
        );
    }

    public function departmentRevenue()
    {
        return view('admin.accountant.reports.department_revenue');
    }

    public function opdIpdRevenue()
    {
        return view('admin.accountant.reports.opd_ipd_revenue');
    }

    public function outstandingDues()
    {
        return view('admin.accountant.reports.outstanding_dues');
    }

    public function insuranceSettlement()
    {
        return view('admin.accountant.reports.insurance_settlement');
    }

    public function refundReport()
    {
        return view('admin.accountant.reports.refund_report');
    }

    public function expenseReport()
    {
        return view('admin.accountant.reports.expense_report');
    }

    public function profitLoss()
    {
        return view('admin.accountant.reports.profit_loss');
    }
}