<?php

namespace App\Http\Controllers\Api\Reports;

use App\Http\Controllers\Controller;

class LeaveReportApiController extends Controller
{
    public function index()
    {
        $data = \App\Models\LeaveApplication::with(['staff','leaveType','approvals'])
            ->latest()
            ->get();

        return response()->json($data);
    }
}