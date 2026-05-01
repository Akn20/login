<?php

namespace App\Http\Controllers\Api\Reports;

use App\Http\Controllers\Controller;

class OvertimeReportApiController extends Controller
{
    public function index()
    {
        $records = \App\Models\AttendanceRecord::with(['staff','department'])
            ->where('overtime_minutes','>',0)
            ->get();

        foreach ($records as $r) {
            $r->overtime_hours = $r->overtime_minutes / 60;
            $r->amount = $r->overtime_hours * 100;
        }

        return response()->json($records);
    }
}