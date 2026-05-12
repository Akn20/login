<?php

namespace App\Http\Controllers\Api\Reports;

use App\Http\Controllers\Controller;

class DepartmentSalaryApiController extends Controller
{
    public function index()
    {
        $staff = \App\Models\Staff::with('department')->get();

        $group = [];

        foreach ($staff as $s) {

            $dept = $s->department->name ?? 'Unknown';

            $salary = ($s->basic_salary ?? 0) + $s->hra + $s->allowance;

            $group[$dept][] = $salary;
        }

        $result = [];

        foreach ($group as $dept => $salaries) {
            $result[] = [
                'department' => $dept,
                'employees' => count($salaries),
                'total' => array_sum($salaries),
                'average' => array_sum($salaries)/count($salaries),
                'max' => max($salaries),
                'min' => min($salaries),
            ];
        }

        return response()->json($result);
    }
}