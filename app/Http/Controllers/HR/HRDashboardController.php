<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;

class HRDashboardController extends Controller
{
    public function index()
    {
        return view('hr.dashboard.index');
    }
}
