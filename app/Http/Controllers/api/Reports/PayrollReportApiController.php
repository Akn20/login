<?php

namespace App\Http\Controllers\Api\Reports;

use App\Http\Controllers\Controller;


class PayrollReportApiController extends Controller
{
    public function index()
    {
        $staff = \App\Models\Staff::with('department')->get();

        $report = [];

        foreach ($staff as $s) {

            $basic = $s->basic_salary ?? 0;
            $allowances = $s->hra + $s->allowance;
            $gross = $basic + $allowances;

            $pf = $basic * 0.12;
            $esi = ($gross <= 21000) ? $gross * 0.0075 : 0;
            $tax = $gross * 0.05;

            $deductions = $pf + $esi + $tax;
            $net = $gross - $deductions;

            $report[] = [
                'employee_id' => $s->employee_id,
                'name' => $s->name,
                'department' => $s->department->name ?? '-',
                'gross' => $gross,
                'net' => $net,
            ];
        }

        return response()->json($report);
    }
}