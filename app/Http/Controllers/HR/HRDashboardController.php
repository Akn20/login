<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\LeaveApplication;
use App\Models\Staff;
use Carbon\Carbon;

class HRDashboardController extends Controller
{
    public function index()
{
    try {

        // Top stats
        $totalEmployees = Staff::count();

        $activeStaff = Staff::where(
            'status',
            'active'
        )->count();

        $pendingLeaves = LeaveApplication::where(
            'status',
            'pending'
        )->count();

        // Department headcount
        $departments = Staff::selectRaw(
            'department_id, COUNT(*) as total'
        )
        ->with(
            'department:id,department_name'
        )
        ->groupBy('department_id')
        ->get();

        $departmentLabels =
            $departments->map(
                fn ($row) =>
                    $row->department
                        ->department_name
                    ?? 'Unknown'
            );

        $departmentCounts =
            $departments->pluck('total');

        // Attendance last 7 days
        $rangeDays = 7;

        $fromDate =
            Carbon::today()
                ->subDays(
                    $rangeDays - 1
                );

        $dates = collect();

        for (
            $i = $rangeDays - 1;
            $i >= 0;
            $i--
        ) {
            $dates->push(
                Carbon::today()
                    ->subDays($i)
                    ->format('Y-m-d')
            );
        }

        $attendance =
            AttendanceRecord::selectRaw(
                "attendance_date,
                SUM(
                    CASE
                    WHEN status = 'present'
                    THEN 1
                    ELSE 0
                    END
                ) as present_total,

                SUM(
                    CASE
                    WHEN status = 'absent'
                    THEN 1
                    ELSE 0
                    END
                ) as absent_total"
            )
            ->whereDate(
                'attendance_date',
                '>=',
                $fromDate
            )
            ->groupBy(
                'attendance_date'
            )
            ->orderBy(
                'attendance_date'
            )
            ->get();

        $attendanceMap =
            $attendance->mapWithKeys(
                function ($row) {

                    $key =
                        Carbon::parse(
                            $row->attendance_date
                        )
                        ->format(
                            'Y-m-d'
                        );

                    return [
                        $key => [
                            'present' =>
                                (int)
                                $row
                                    ->present_total,

                            'absent' =>
                                (int)
                                $row
                                    ->absent_total,
                        ],
                    ];
                }
            );

        $presentCounts =
            $dates->map(
                fn ($d) =>
                    $attendanceMap[$d]['present']
                    ?? 0
            );

        $absentCounts =
            $dates->map(
                fn ($d) =>
                    $attendanceMap[$d]['absent']
                    ?? 0
            );

        // Status distribution
        $statusLabels = [
            'Active',
            'Inactive'
        ];

        $statusCounts = [
            Staff::where(
                'status',
                'active'
            )->count(),

            Staff::where(
                'status',
                'inactive'
            )->count(),
        ];

        // IMPORTANT — return JSON
        return response()->json([

            'success' => true,

            'data' => [

                'totalEmployees' =>
                    $totalEmployees,

                'activeStaff' =>
                    $activeStaff,

                'pendingLeaves' =>
                    $pendingLeaves,

                'departmentLabels' =>
                    $departmentLabels,

                'departmentCounts' =>
                    $departmentCounts,

                'attendanceLabels' =>
                    $dates,

                'presentCounts' =>
                    $presentCounts,

                'absentCounts' =>
                    $absentCounts,

                'statusLabels' =>
                    $statusLabels,

                'statusCounts' =>
                    $statusCounts,

                // needed for your dashboard card
                'totalReports' => 6,
            ],
        ]);

    } catch (\Exception $e) {

        return response()->json([

            'success' => false,

            'message' =>
                $e->getMessage(),

            'data' => [
                'totalEmployees' => 0,
                'totalReports' => 6,
            ],
        ], 500);
    }
}
}
