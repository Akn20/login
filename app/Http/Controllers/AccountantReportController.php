<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountantReportController extends Controller
{

    public function dailyCollection()
    {
        return view('admin.accountant.reports.daily_collection');
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