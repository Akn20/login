<?php

namespace App\Http\Controllers\HR\Reports;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentSalaryReportController extends Controller
{
    public function index(Request $request)
    {
        $staff = Staff::with('department')->get();

        $departments = [];

        foreach ($staff as $s) {

            $deptName = $s->department->name ?? 'Unknown';

            // 🔁 Calculate salary (reuse logic)
            $basic = $s->basic_salary ?? 0;
            $allowances = $s->hra + $s->allowance;
            $gross = $basic + $allowances;

            // deductions (simple for now)
            $deductions = $gross * 0.1;

            $net = $gross - $deductions;

            // 🧠 Group by department
            if (!isset($departments[$deptName])) {
                $departments[$deptName] = [
                    'employees' => 0,
                    'total_salary' => 0,
                    'salaries' => []
                ];
            }

            $departments[$deptName]['employees']++;
            $departments[$deptName]['total_salary'] += $net;
            $departments[$deptName]['salaries'][] = $net;
        }

        // 📊 Final Calculations
        $report = [];

        foreach ($departments as $dept => $data) {

            $total = $data['total_salary'];
            $count = $data['employees'];

            $report[] = [
                'department' => $dept,
                'employees' => $count,
                'total_salary' => round($total, 2),
                'average_salary' => round($total / $count, 2),
                'highest_salary' => max($data['salaries']),
                'lowest_salary' => min($data['salaries']),
            ];
        }

        return view('admin.hr.reports.department-salary', compact('report'));
    }
}