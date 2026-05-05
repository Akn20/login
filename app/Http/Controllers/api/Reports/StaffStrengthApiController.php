<?php

namespace App\Http\Controllers\Api\Reports;

use App\Http\Controllers\Controller;
use App\Models\Staff;

class StaffStrengthApiController extends Controller
{
    public function  apiIndex()
{
    try {

        $staff = Staff::with([
            'department',
            'designation',
            'role'
        ])->get();

        $report = [];

        foreach ($staff as $s) {

            $report[] = [

                'employeeId' =>
                    $s->employee_id,

                'name' =>
                    $s->name,

                'department' =>
                    $s->department
                        ->department_name
                        ?? '-',

                'designation' =>
                    $s->designation
                        ->designation_name
                        ?? '-',

                'status' =>
                    $s->status
                    ?? 'Active',
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $report
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
}