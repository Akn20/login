<?php

namespace App\Http\Controllers\HR\Reports;

use App\Http\Controllers\Controller;

class ReportsDashboardController extends Controller
{
    public function index()
    {
        return view('admin.hr.reports.dashboard');
    }
}