<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\InventoryVendor;
use App\Models\IPDPayment;
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

        // From Date Filter
        if ($request->from_date) {

            $query->whereDate(
                'entry_date',
                '>=',
                $request->from_date
            );
        }

        // To Date Filter
        if ($request->to_date) {

            $query->whereDate(
                'entry_date',
                '<=',
                $request->to_date
            );
        }

        // Category Filter
        if ($request->category_id) {

            $query->where(
                'category_id',
                $request->category_id
            );
        }

        // Vendor Filter
        if ($request->vendor_id) {

            $query->where(
                'vendor_id',
                $request->vendor_id
            );
        }

        // Payment Status Filter
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

        // Final Total
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
    /*
    |--------------------------------------------------------------------------
    | IPD PAYMENT INCOME
    |--------------------------------------------------------------------------
    */

    $ipdIncomeQuery = IPDPayment::query();

    if ($request->from_date) {

        $ipdIncomeQuery->whereDate(
            'created_at',
            '>=',
            $request->from_date
        );
    }

    if ($request->to_date) {

        $ipdIncomeQuery->whereDate(
            'created_at',
            '<=',
            $request->to_date
        );
    }

    $ipdPayments = $ipdIncomeQuery
                        ->latest()
                        ->get();

    $ipdIncome = $ipdPayments->sum('amount');


    /*
    |--------------------------------------------------------------------------
    | SALES BILL INCOME
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | TOTAL INCOME
    |--------------------------------------------------------------------------
    */

    $totalIncome =
        $ipdIncome +
        $salesIncome;


    /*
    |--------------------------------------------------------------------------
    | EXPENSE DATA
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | TOTAL EXPENSE
    |--------------------------------------------------------------------------
    */

    $totalExpense = $expenses->sum('grand_total');


    /*
    |--------------------------------------------------------------------------
    | BALANCE
    |--------------------------------------------------------------------------
    */

    $balance =
        $totalIncome -
        $totalExpense;


    /*
    |--------------------------------------------------------------------------
    | RETURN VIEW
    |--------------------------------------------------------------------------
    */

    return view(
        'admin.Accountant.Expense_Management.ExpenseReport.income_expense_report',
        compact(
            'ipdPayments',
            'salesBills',
            'expenses',
            'ipdIncome',
            'salesIncome',
            'totalIncome',
            'totalExpense',
            'balance'
        )
    );
}
}