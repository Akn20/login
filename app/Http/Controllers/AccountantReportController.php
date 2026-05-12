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

            /*
            |--------------------------------------------------------------------------
            | PHARMACY COLLECTIONS
            |--------------------------------------------------------------------------
            */

            $pharmacyQuery = DB::table('sales_bills')

                ->leftJoin(
                    'patients',
                    'sales_bills.patient_id',
                    '=',
                    'patients.id'
                )

                ->select(

                    'sales_bills.bill_id as id',

                    'sales_bills.bill_number as bill_no',

                    'sales_bills.paid_amount as amount',

                    'sales_bills.payment_mode',

                    'sales_bills.created_at as payment_date',

                    DB::raw("'PHARMACY' as type"),

                    DB::raw("
                        COALESCE(
                            CONCAT(patients.first_name, ' ', patients.last_name),
                            sales_bills.patient_name
                        ) as patient_name
                    ")

                );

            if ($request->from_date) {

                $pharmacyQuery->whereDate(
                    'sales_bills.created_at',
                    '>=',
                    $request->from_date
                );
            }

            if ($request->to_date) {

                $pharmacyQuery->whereDate(
                    'sales_bills.created_at',
                    '<=',
                    $request->to_date
                );
            }

            if ($request->payment_mode) {

                $pharmacyQuery->whereRaw(
                    'LOWER(sales_bills.payment_mode) = ?',
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

            ->unionAll($pharmacyQuery)

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

    public function departmentRevenue(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | DATE FILTERS
        |--------------------------------------------------------------------------
        */

        $fromDate = $request->from_date;
        $toDate   = $request->to_date;

        /*
        |--------------------------------------------------------------------------
        | FINAL ARRAY
        |--------------------------------------------------------------------------
        */

        $reportData = collect();

        /*
        |--------------------------------------------------------------------------
        | OPD REVENUE
        |--------------------------------------------------------------------------
        */

        $opdQuery = DB::table('receptionist_billing')
            ->select(
                DB::raw("'OPD' as department_name"),
                DB::raw("SUM(amount) as total_revenue"),
                DB::raw("COUNT(id) as total_bills")
            );

        if ($fromDate) {

            $opdQuery->whereDate(
                'created_at',
                '>=',
                $fromDate
            );
        }

        if ($toDate) {

            $opdQuery->whereDate(
                'created_at',
                '<=',
                $toDate
            );
        }

        $opdRevenue = $opdQuery->first();

        if ($opdRevenue) {

            $reportData->push($opdRevenue);
        }


        /*
        |--------------------------------------------------------------------------
        | IPD REVENUE
        |--------------------------------------------------------------------------
        */

        $ipdQuery = DB::table('ipd_bills')

            ->select(

                DB::raw("'Inpatient Department (IPD)' as department_name"),

                DB::raw("SUM(grand_total) as total_revenue"),

                DB::raw("COUNT(id) as total_bills")

            );

        if ($fromDate) {

            $ipdQuery->whereDate(
                'bill_date',
                '>=',
                $fromDate
            );
        }

        if ($toDate) {

            $ipdQuery->whereDate(
                'bill_date',
                '<=',
                $toDate
            );
        }

        /*
        |--------------------------------------------------------------------------
        | IPD DEPARTMENT BREAKDOWN
        |--------------------------------------------------------------------------
        */

        $departmentQuery = DB::table('ipd_bills')

            ->leftJoin(
                'ipd_admissions',
                'ipd_bills.ipd_id',
                '=',
                'ipd_admissions.id'
            )

            ->leftJoin(
                'department_master',
                'ipd_admissions.department_id',
                '=',
                'department_master.id'
            )

            ->select(

                'department_master.department_name',

                DB::raw("SUM(ipd_bills.grand_total) as total_revenue"),

                DB::raw("COUNT(ipd_bills.id) as total_bills")

            )

            ->groupBy('department_master.department_name');

        if ($fromDate) {

            $departmentQuery->whereDate(
                'ipd_bills.bill_date',
                '>=',
                $fromDate
            );
        }

        if ($toDate) {

            $departmentQuery->whereDate(
                'ipd_bills.bill_date',
                '<=',
                $toDate
            );
        }

        $departmentRevenue = $departmentQuery->get();

        foreach ($departmentRevenue as $department) {

            $reportData->push($department);
        }

        /*
        |--------------------------------------------------------------------------
        | OPTIONAL
        |--------------------------------------------------------------------------
        |
        | Uncomment if you want only final bills
        |
        */

        # $ipdQuery->where('status', 'final');

        $ipdRevenue = $ipdQuery->first();

        if ($ipdRevenue) {

            $reportData->push($ipdRevenue);
        }

        /*
        |--------------------------------------------------------------------------
        | LAB REVENUE
        |--------------------------------------------------------------------------
        */

        $labQuery = DB::table('ipd_bill_items')
            ->where('type', 'Lab')
            ->select(
                DB::raw("'Laboratory' as department_name"),
                DB::raw("SUM(amount) as total_revenue"),
                DB::raw("COUNT(id) as total_bills")
            );

        if ($fromDate) {

            $labQuery->whereDate(
                'created_at',
                '>=',
                $fromDate
            );
        }

        if ($toDate) {

            $labQuery->whereDate(
                'created_at',
                '<=',
                $toDate
            );
        }

        $labRevenue = $labQuery->first();

        if ($labRevenue && $labRevenue->total_revenue > 0) {

            $reportData->push($labRevenue);
        }

        /*
        |--------------------------------------------------------------------------
        | RADIOLOGY REVENUE
        |--------------------------------------------------------------------------
        */

        $scanQuery = DB::table('ipd_bill_items')
            ->where('type', 'Scan')
            ->select(
                DB::raw("'Radiology' as department_name"),
                DB::raw("SUM(amount) as total_revenue"),
                DB::raw("COUNT(id) as total_bills")
            );

        if ($fromDate) {

            $scanQuery->whereDate(
                'created_at',
                '>=',
                $fromDate
            );
        }

        if ($toDate) {

            $scanQuery->whereDate(
                'created_at',
                '<=',
                $toDate
            );
        }

        $scanRevenue = $scanQuery->first();

        if ($scanRevenue && $scanRevenue->total_revenue > 0) {

            $reportData->push($scanRevenue);
        }

        /*
        |--------------------------------------------------------------------------
        | PHARMACY REVENUE
        |--------------------------------------------------------------------------
        */

        $pharmacyTotal = 0;

        $salesBillQuery = DB::table('sales_bills');

        if ($fromDate) {

            $salesBillQuery->whereDate(
                'created_at',
                '>=',
                $fromDate
            );
        }

        if ($toDate) {

            $salesBillQuery->whereDate(
                'created_at',
                '<=',
                $toDate
            );
        }

        $pharmacyTotal += $salesBillQuery->sum('total_amount');

        /*
        |--------------------------------------------------------------------------
        | IPD PHARMACY ITEMS
        |--------------------------------------------------------------------------
        */

        $ipdPharmacyQuery = DB::table('ipd_bill_items')
            ->where('type', 'Pharmacy');

        if ($fromDate) {

            $ipdPharmacyQuery->whereDate(
                'created_at',
                '>=',
                $fromDate
            );
        }

        if ($toDate) {

            $ipdPharmacyQuery->whereDate(
                'created_at',
                '<=',
                $toDate
            );
        }

        $ipdPharmacyAmount = $ipdPharmacyQuery->sum('amount');

        $pharmacyTotal += $ipdPharmacyAmount;

        /*
        |--------------------------------------------------------------------------
        | PUSH TO REPORT
        |--------------------------------------------------------------------------
        */

        if ($pharmacyTotal > 0) {

            $reportData->push((object)[

                'department_name' => 'Pharmacy',

                'total_revenue' => $pharmacyTotal,

                'total_bills' => 0

            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | DEPARTMENT FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->department) {

            $reportData = $reportData->filter(function ($row) use ($request) {

                return strtolower($row->department_name)
                    == strtolower($request->department);

            })->values();
        }
        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

        $totalRevenue = 0;

        /*
        |--------------------------------------------------------------------------
        | OPD TOTAL
        |--------------------------------------------------------------------------
        */

        $totalRevenue += DB::table('receptionist_billing')

            ->when($fromDate, function ($query) use ($fromDate) {

                $query->whereDate(
                    'created_at',
                    '>=',
                    $fromDate
                );

            })

            ->when($toDate, function ($query) use ($toDate) {

                $query->whereDate(
                    'created_at',
                    '<=',
                    $toDate
                );

            })

            ->sum('amount');

        /*
        |--------------------------------------------------------------------------
        | IPD TOTAL
        |--------------------------------------------------------------------------
        */

        $totalRevenue += DB::table('ipd_bills')

            ->when($fromDate, function ($query) use ($fromDate) {

                $query->whereDate(
                    'bill_date',
                    '>=',
                    $fromDate
                );

            })

            ->when($toDate, function ($query) use ($toDate) {

                $query->whereDate(
                    'bill_date',
                    '<=',
                    $toDate
                );

            })

            ->sum('grand_total');

        $totalDepartments = $reportData->count();

        /*
        |--------------------------------------------------------------------------
        | HIGHEST REVENUE DEPARTMENT
        |--------------------------------------------------------------------------
        */

        $highestDepartment = $reportData

            ->filter(function ($item) {

                return is_object($item)
                    && isset($item->department_name)
                    && strtolower($item->department_name)
                        != 'inpatient department (ipd)';

            })

            ->sortByDesc(function ($item) {

                return (float) $item->total_revenue;

            })

            ->first();
        $departments = DB::table('department_master')
            ->orderBy('department_name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.Accountant.Reports.department_revenue',
            compact(
                'reportData',
                'totalRevenue',
                'totalDepartments',
                'highestDepartment',
                'departments'
            )
        );
    }

    public function opdIpdRevenue(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | DATE FILTERS
        |--------------------------------------------------------------------------
        */

        $fromDate = $request->from_date;

        $toDate   = $request->to_date;

        /*
        |--------------------------------------------------------------------------
        | OPD REVENUE
        |--------------------------------------------------------------------------
        */

        $opdQuery = DB::table('receptionist_billing')

            ->select(

                DB::raw("DATE(created_at) as revenue_date"),

                DB::raw("SUM(amount) as opd_revenue")

            );

        if ($fromDate) {

            $opdQuery->whereDate(
                'created_at',
                '>=',
                $fromDate
            );
        }

        if ($toDate) {

            $opdQuery->whereDate(
                'created_at',
                '<=',
                $toDate
            );
        }

        $opdRevenue = $opdQuery

            ->groupBy(DB::raw("DATE(created_at)"))

            ->pluck(
                'opd_revenue',
                'revenue_date'
            );

        /*
        |--------------------------------------------------------------------------
        | IPD REVENUE
        |--------------------------------------------------------------------------
        */

        $ipdQuery = DB::table('ipd_bills')

            ->select(

                DB::raw("DATE(bill_date) as revenue_date"),

                DB::raw("SUM(grand_total) as ipd_revenue")

            );

        if ($fromDate) {

            $ipdQuery->whereDate(
                'bill_date',
                '>=',
                $fromDate
            );
        }

        if ($toDate) {

            $ipdQuery->whereDate(
                'bill_date',
                '<=',
                $toDate
            );
        }

        $ipdRevenue = $ipdQuery

            ->groupBy(DB::raw("DATE(bill_date)"))

            ->pluck(
                'ipd_revenue',
                'revenue_date'
            );

        /*
        |--------------------------------------------------------------------------
        | MERGE DATES
        |--------------------------------------------------------------------------
        */

        $allDates = collect(
            array_unique(
                array_merge(
                    $opdRevenue->keys()->toArray(),
                    $ipdRevenue->keys()->toArray()
                )
            )
        )->sort();

        /*
        |--------------------------------------------------------------------------
        | FINAL REPORT DATA
        |--------------------------------------------------------------------------
        */

        $reportData = collect();

        foreach ($allDates as $date) {

            $opdAmount = $opdRevenue[$date] ?? 0;

            $ipdAmount = $ipdRevenue[$date] ?? 0;

            $reportData->push((object)[

                'date'         => $date,

                'opd_revenue'  => $opdAmount,

                'ipd_revenue'  => $ipdAmount,

                'total'        => $opdAmount + $ipdAmount

            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

        $totalOpdRevenue = $reportData->sum('opd_revenue');

        $totalIpdRevenue = $reportData->sum('ipd_revenue');

        $totalRevenue = $totalOpdRevenue + $totalIpdRevenue;

        $difference = abs(
            $totalIpdRevenue - $totalOpdRevenue
        );

        $highestRevenueSource = $totalIpdRevenue > $totalOpdRevenue
            ? 'IPD'
            : 'OPD';

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.Accountant.Reports.opd_ipd_revenue',
            compact(
                'reportData',
                'totalOpdRevenue',
                'totalIpdRevenue',
                'totalRevenue',
                'difference',
                'highestRevenueSource'
            )
        );
    }

    public function outstandingDues(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTERS
        |--------------------------------------------------------------------------
        */

        $fromDate = $request->from_date;

        $toDate   = $request->to_date;

        $type     = $request->type;

        /*
        |--------------------------------------------------------------------------
        | FINAL COLLECTION
        |--------------------------------------------------------------------------
        */

        $reportData = collect();

        /*
        |--------------------------------------------------------------------------
        | IPD OUTSTANDING
        |--------------------------------------------------------------------------
        */

        if (!$type || $type == 'IPD') {

            $ipdBills = DB::table('ipd_bills')

                ->leftJoin(
                    'patients',
                    'ipd_bills.patient_id',
                    '=',
                    'patients.id'
                )

                ->leftJoin(
                    'accountant_payments',
                    'ipd_bills.id',
                    '=',
                    'accountant_payments.bill_id'
                )

                ->select(

                    'ipd_bills.bill_no',

                    'ipd_bills.payable_amount',

                    DB::raw("
                        CONCAT(
                            patients.first_name,
                            ' ',
                            patients.last_name
                        ) as patient_name
                    "),

                    DB::raw("
                        COALESCE(
                            SUM(accountant_payments.amount),
                            0
                        ) as paid_amount
                    "),

                    DB::raw("
                        (
                            ipd_bills.payable_amount
                            -
                            COALESCE(
                                SUM(accountant_payments.amount),
                                0
                            )
                        ) as pending_amount
                    "),

                    DB::raw("'IPD' as type"),

                    'ipd_bills.bill_date'

                )

                ->groupBy(
                    'ipd_bills.id',
                    'ipd_bills.bill_no',
                    'ipd_bills.payable_amount',
                    'patients.first_name',
                    'patients.last_name',
                    'ipd_bills.bill_date'
                );

            if ($fromDate) {

                $ipdBills->whereDate(
                    'ipd_bills.bill_date',
                    '>=',
                    $fromDate
                );
            }

            if ($toDate) {

                $ipdBills->whereDate(
                    'ipd_bills.bill_date',
                    '<=',
                    $toDate
                );
            }

            $ipdBills = $ipdBills
                ->having('pending_amount', '>', 0)
                ->get();

            foreach ($ipdBills as $bill) {

                $reportData->push($bill);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | PHARMACY OUTSTANDING
        |--------------------------------------------------------------------------
        */

        if (!$type || $type == 'Pharmacy') {

            $pharmacyBills = DB::table('sales_bills')

                ->leftJoin(
                    'patients',
                    'sales_bills.patient_id',
                    '=',
                    'patients.id'
                )

                ->select(

                    'sales_bills.bill_number as bill_no',

                    'sales_bills.total_amount as payable_amount',

                    DB::raw("
                        COALESCE(
                            CONCAT(
                                patients.first_name,
                                ' ',
                                patients.last_name
                            ),
                            sales_bills.patient_name
                        ) as patient_name
                    "),

                    'sales_bills.paid_amount',

                    'sales_bills.balance_amount as pending_amount',

                    DB::raw("'Pharmacy' as type"),

                    'sales_bills.created_at as bill_date'

                );

            if ($fromDate) {

                $pharmacyBills->whereDate(
                    'sales_bills.created_at',
                    '>=',
                    $fromDate
                );
            }

            if ($toDate) {

                $pharmacyBills->whereDate(
                    'sales_bills.created_at',
                    '<=',
                    $toDate
                );
            }

            $pharmacyBills = $pharmacyBills
                ->where('sales_bills.balance_amount', '>', 0)
                ->get();

            foreach ($pharmacyBills as $bill) {

                $reportData->push($bill);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SORT LATEST FIRST
        |--------------------------------------------------------------------------
        */

        $reportData = $reportData->sortByDesc('bill_date');

        /*
        |--------------------------------------------------------------------------
        | SUMMARY CARDS
        |--------------------------------------------------------------------------
        */

        $totalOutstanding = $reportData->sum('pending_amount');

        $ipdOutstanding = $reportData

            ->where('type', 'IPD')

            ->sum('pending_amount');

        $pharmacyOutstanding = $reportData

            ->where('type', 'Pharmacy')

            ->sum('pending_amount');

        $totalPendingBills = $reportData->count();

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.Accountant.Reports.outstanding_dues',
            compact(
                'reportData',
                'totalOutstanding',
                'ipdOutstanding',
                'pharmacyOutstanding',
                'totalPendingBills'
            )
        );
    }

    public function insuranceSettlement(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | MAIN QUERY
        |--------------------------------------------------------------------------
        */

        $query = DB::table('insurance_claims')

            ->leftJoin(
                'patients',
                'insurance_claims.patient_id',
                '=',
                'patients.id'
            )

            ->leftJoin(
                'claim_approvals',
                'insurance_claims.id',
                '=',
                'claim_approvals.claim_id'
            )

            ->leftJoin(
                'claim_payments',
                'insurance_claims.id',
                '=',
                'claim_payments.claim_id'
            )

            ->leftJoin(
                'claim_reconciliations',
                'insurance_claims.id',
                '=',
                'claim_reconciliations.claim_id'
            )

            ->select(

                'insurance_claims.id',

                'insurance_claims.claim_number',

                'insurance_claims.insurance_provider',

                'insurance_claims.claim_date',

                'insurance_claims.status',

                'insurance_claims.billed_amount',

                DB::raw("
                    CONCAT(
                        patients.first_name,
                        ' ',
                        patients.last_name
                    ) as patient_name
                "),

                DB::raw("
                    COALESCE(
                        SUM(DISTINCT claim_approvals.approved_amount),
                        0
                    ) as approved_amount
                "),

                DB::raw("
                    COALESCE(
                        SUM(DISTINCT claim_payments.payment_amount),
                        0
                    ) as paid_amount
                "),

                DB::raw("
                    COALESCE(
                        MAX(claim_reconciliations.is_reconciled),
                        0
                    ) as reconciled
                ")

            )

            ->groupBy(

                'insurance_claims.id',
                'insurance_claims.claim_number',
                'insurance_claims.insurance_provider',
                'insurance_claims.claim_date',
                'insurance_claims.status',
                'insurance_claims.billed_amount',
                'patients.first_name',
                'patients.last_name'

            );

        /*
        |--------------------------------------------------------------------------
        | FILTERS
        |--------------------------------------------------------------------------
        */

        if ($request->from_date) {

            $query->whereDate(
                'insurance_claims.claim_date',
                '>=',
                $request->from_date
            );
        }

        if ($request->to_date) {

            $query->whereDate(
                'insurance_claims.claim_date',
                '<=',
                $request->to_date
            );
        }

        if ($request->provider) {

            $query->where(
                'insurance_claims.insurance_provider',
                $request->provider
            );
        }

        if ($request->status) {

            $query->where(
                'insurance_claims.status',
                $request->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | GET DATA
        |--------------------------------------------------------------------------
        */

        $claims = $query
            ->orderByDesc('insurance_claims.claim_date')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

        $totalClaims = $claims->sum('billed_amount');

        $totalApproved = $claims->sum('approved_amount');

        $totalPaid = $claims->sum('paid_amount');

        $pendingSettlement = $totalApproved - $totalPaid;

        /*
        |--------------------------------------------------------------------------
        | INSURANCE PROVIDERS
        |--------------------------------------------------------------------------
        */

        $providers = DB::table('insurance_claims')
            ->select('insurance_provider')
            ->distinct()
            ->orderBy('insurance_provider')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.Accountant.Reports.insurance_settlement',
            compact(
                'claims',
                'totalClaims',
                'totalApproved',
                'totalPaid',
                'pendingSettlement',
                'providers'
            )
        );
    }

    public function refundReport(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | MAIN QUERY
        |--------------------------------------------------------------------------
        */

        $query = DB::table('refunds')

            ->leftJoin(
                'patients',
                'refunds.patient_id',
                '=',
                'patients.id'
            )

            ->leftJoin(
                'refund_approval_logs',
                'refunds.id',
                '=',
                'refund_approval_logs.refund_id'
            )

            ->select(

                'refunds.id',

                'refunds.refund_no',

                'refunds.bill_type',

                'refunds.refund_type',

                'refunds.refund_amount',

                'refunds.refund_date',

                'refunds.refund_reason',

                'refunds.refund_mode',

                'refunds.status',

                'refunds.transaction_no',

                DB::raw("
                    CONCAT(
                        patients.first_name,
                        ' ',
                        patients.last_name
                    ) as patient_name
                "),

                DB::raw("
                    MAX(refund_approval_logs.approval_status)
                    as approval_status
                ")

            )

            ->groupBy(

                'refunds.id',
                'refunds.refund_no',
                'refunds.bill_type',
                'refunds.refund_type',
                'refunds.refund_amount',
                'refunds.refund_date',
                'refunds.refund_reason',
                'refunds.refund_mode',
                'refunds.status',
                'refunds.transaction_no',
                'patients.first_name',
                'patients.last_name'

            );

        /*
        |--------------------------------------------------------------------------
        | FILTERS
        |--------------------------------------------------------------------------
        */

        if ($request->from_date) {

            $query->whereDate(
                'refunds.refund_date',
                '>=',
                $request->from_date
            );
        }

        if ($request->to_date) {

            $query->whereDate(
                'refunds.refund_date',
                '<=',
                $request->to_date
            );
        }

        if ($request->refund_type) {

            $query->where(
                'refunds.refund_type',
                $request->refund_type
            );
        }

        if ($request->status) {

            $query->where(
                'refunds.status',
                $request->status
            );
        }

        if ($request->refund_mode) {

            $query->where(
                'refunds.refund_mode',
                $request->refund_mode
            );
        }

        /*
        |--------------------------------------------------------------------------
        | GET DATA
        |--------------------------------------------------------------------------
        */

        $refunds = $query
            ->orderByDesc('refunds.refund_date')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

        $totalRefundAmount = $refunds->sum('refund_amount');

        $approvedRefundAmount = $refunds

            ->filter(function ($item) {

                return strtolower($item->approval_status) == 'approved';

            })

            ->sum('refund_amount');

        $pendingRefundAmount = $refunds

            ->filter(function ($item) {

                return in_array(
                    strtolower($item->status),
                    ['pending', 'under verification']
                );

            })

            ->sum('refund_amount');

        $refundCount = $refunds->count();

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.Accountant.Reports.refund_report',
            compact(
                'refunds',
                'totalRefundAmount',
                'approvedRefundAmount',
                'pendingRefundAmount',
                'refundCount'
            )
        );
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