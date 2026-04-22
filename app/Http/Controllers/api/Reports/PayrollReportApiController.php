<?php

namespace App\Http\Controllers\Api\Reports;

use App\Http\Controllers\Controller;
use App\Models\Staff;

class PayrollReportApiController extends Controller
{
    public function index()
    {
        $staff = Staff::with('department')->get();

        $report = [];

        foreach ($staff as $s) {

            $basic = $s->basic_salary ?? 0;

            $allowances =
                ($s->hra ?? 0) +
                ($s->allowance ?? 0);

            $gross = $basic + $allowances;

            $pf = round($basic * 0.12, 2);

            $esi =
                ($gross <= 21000)
                ? round($gross * 0.0075, 2)
                : 0;

            $tax = round($gross * 0.05, 2);

            $deductions =
                $pf + $esi + $tax;

            $net =
                $gross - $deductions;

            $report[] = [

                'id' => $s->id,

                'employee_id' =>
                    $s->employee_id,

                'name' =>
                    $s->name,

                'department_name' =>
                    $s->department
                        ->department_name
                        ?? '-',

                'basic' =>
                    $basic,

                'allowances' =>
                    $allowances,

                'pf' =>
                    $pf,

                'esi' =>
                    $esi,

                'tax' =>
                    $tax,

                'deductions' =>
                    $deductions,

                'gross' =>
                    $gross,

                'net' =>
                    $net,

                'status' =>
                    'Processed',
            ];
        }

        return response()->json($report);
    }
}