<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\InventoryVendor;
use App\Models\ReceptionistBilling;
use App\Models\AccountantPayment;
use App\Models\SalesBill;

class ExpenseReportController extends Controller
{
    /**
     * Report Filter Page
     */
    public function index()
    {
        $categories = ExpenseCategory::where('is_deleted', false)
                        ->orderBy('category_name')
                        ->get();

        $vendors = InventoryVendor::whereNull('deleted_at')
                        ->orderBy('vendor_name')
                        ->get();

        return view(
            'admin.Accountant.Expense_Management.ExpenseReport.index',
            compact('categories', 'vendors')
        );
    }

    /**
     * Category Wise Expense Report
     */
    public function categoryWiseReport(Request $request)
    {
        $query = Expense::with([
            'category',
            'vendor',
            'items'
        ]);

        if ($request->from_date) {
            $query->whereDate(
                'entry_date',
                '>=',
                $request->from_date
            );
        }

        if ($request->to_date) {
            $query->whereDate(
                'entry_date',
                '<=',
                $request->to_date
            );
        }

        if ($request->category_id) {
            $query->where(
                'category_id',
                $request->category_id
            );
        }

        if ($request->vendor_id) {
            $query->where(
                'vendor_id',
                $request->vendor_id
            );
        }

        if (
            $request->payment_status &&
            $request->payment_status != 'All'
        ) {
            $query->where(
                'payment_status',
                $request->payment_status
            );
        }

        $expenses = $query->latest()->get();

        $finalTotal = $expenses->sum('grand_total');

        return view(
            'admin.Accountant.Expense_Management.ExpenseReport.category_report',
            compact(
                'expenses',
                'finalTotal'
            )
        );
    }

    /**
     * Income & Expense Report
     */
    public function incomeExpenseReport(Request $request)
    {
        $receptionistIncomeQuery = ReceptionistBilling::query();

        if ($request->from_date) {
            $receptionistIncomeQuery->whereDate(
                'created_at',
                '>=',
                $request->from_date
            );
        }

        if ($request->to_date) {
            $receptionistIncomeQuery->whereDate(
                'created_at',
                '<=',
                $request->to_date
            );
        }

        $receptionistBillings = $receptionistIncomeQuery
                                    ->latest()
                                    ->get();

        $receptionistIncome = $receptionistBillings->sum('amount');


        $accountantIncomeQuery = AccountantPayment::query();

        if ($request->from_date) {
            $accountantIncomeQuery->whereDate(
                'created_at',
                '>=',
                $request->from_date
            );
        }

        if ($request->to_date) {
            $accountantIncomeQuery->whereDate(
                'created_at',
                '<=',
                $request->to_date
            );
        }

        $accountantPayments = $accountantIncomeQuery
                                    ->latest()
                                    ->get();

        $accountantIncome = $accountantPayments->sum('amount');


        $salesIncomeQuery = SalesBill::query();

        if ($request->from_date) {
            $salesIncomeQuery->whereDate(
                'created_at',
                '>=',
                $request->from_date
            );
        }

        if ($request->to_date) {
            $salesIncomeQuery->whereDate(
                'created_at',
                '<=',
                $request->to_date
            );
        }

        $salesBills = $salesIncomeQuery
                            ->latest()
                            ->get();

        $salesIncome = $salesBills->sum('paid_amount');


        $totalIncome =
            $receptionistIncome +
            $accountantIncome +
            $salesIncome;


        $expenseQuery = Expense::with([
            'category',
            'vendor',
            'items'
        ]);

        if ($request->from_date) {
            $expenseQuery->whereDate(
                'entry_date',
                '>=',
                $request->from_date
            );
        }

        if ($request->to_date) {
            $expenseQuery->whereDate(
                'entry_date',
                '<=',
                $request->to_date
            );
        }

        $expenses = $expenseQuery
                        ->latest()
                        ->get();

        $totalExpense = $expenses->sum('grand_total');

        $balance = $totalIncome - $totalExpense;

        return view(
            'admin.Accountant.Expense_Management.ExpenseReport.income_expense_report',
            compact(
                'receptionistBillings',
                'accountantPayments',
                'salesBills',
                'expenses',

                'receptionistIncome',
                'accountantIncome',
                'salesIncome',

                'totalIncome',
                'totalExpense',
                'balance'
            )
        );
    }

    /**
     * Printable Report
     */
    public function printIncomeExpenseReport(Request $request)
{
    $receptionistBillings = ReceptionistBilling::latest()->get();
    $accountantPayments = AccountantPayment::latest()->get();
    $salesBills = SalesBill::latest()->get();

    $expenses = Expense::with([
        'category',
        'items'
    ])->latest()->get();

    $receptionistIncome = $receptionistBillings->sum('amount');
    $accountantIncome   = $accountantPayments->sum('amount');
    $salesIncome        = $salesBills->sum('paid_amount');

    $totalIncome =
        $receptionistIncome +
        $accountantIncome +
        $salesIncome;

    $totalExpense = $expenses->sum('grand_total');

    $balance =
        $totalIncome -
        $totalExpense;

    return view(
        'admin.Accountant.Expense_Management.ExpenseReport.income_expense_print',
        compact(
            'receptionistBillings',
            'accountantPayments',
            'salesBills',
            'expenses',
            'totalIncome',
            'totalExpense',
            'balance'
        )
    );
}
}