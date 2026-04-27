<?php

namespace App\Http\Controllers\Api\Reports;

use App\Http\Controllers\Controller;

class AttendanceReportApiController extends Controller
{
    public function index()
    {
        $records = \App\Models\AttendanceRecord::with(['staff','department','shift'])
            ->latest()
            ->get();

        return response()->json($records);
    }
}