<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\PerformanceReview;
use App\Models\Staff;
use Illuminate\Support\Str;

class PerformanceManagementController extends Controller
{
    // LIST
    public function index()
    {
        $records = PerformanceReview::latest()
            ->paginate(10);

        return view(
            'hr.performance_management.index',
            compact('records')
        );
    }

    // CREATE PAGE
 public function create()
{
    $employees = Staff::with('department')
        ->where('status', 'Active')
        ->orderBy('employee_id')
        ->get();

    return view(
        'hr.performance_management.create',
        compact('employees')
    );
}

    // STORE
    public function store(Request $request)
    {
        $request->validate([

            'employee_id' => 'required',

            'employee_name' => 'required',

            'department' => 'required',

            'reviewer_name' => 'required',

            'review_date' => 'required',

            'rating' => 'required',
        ]);

        PerformanceReview::create([

            'id' => Str::uuid(),

            'employee_id' => $request->employee_id,

            'employee_name' => $request->employee_name,

            'department' => $request->department,

            'reviewer_name' => $request->reviewer_name,

            'review_date' => $request->review_date,

            'rating' => $request->rating,

            'review_comments' =>
                $request->review_comments,

            'review_status' => 'Pending',

            'cycle_name' =>
                $request->cycle_name,

            'cycle_start_date' =>
                $request->cycle_start_date,

            'cycle_end_date' =>
                $request->cycle_end_date,

            'kpi_name' =>
                $request->kpi_name,

            'target_value' =>
                $request->target_value,

            'achieved_value' =>
                $request->achieved_value,

            'kpi_score' =>
                $request->kpi_score,

            'kpi_remarks' =>
                $request->kpi_remarks,

            'old_designation' =>
                $request->old_designation,

            'new_designation' =>
                $request->new_designation,

            'promotion_date' =>
                $request->promotion_date,

            'promotion_reason' =>
                $request->promotion_reason,

            'warning_type' =>
                $request->warning_type,

            'warning_date' =>
                $request->warning_date,

            'warning_remarks' =>
                $request->warning_remarks,

            'issued_by' =>
                $request->issued_by,

            'action_history' =>
                'Performance Review created on '
                . now(),
        ]);

        return redirect()
            ->route(
                'hr.performance-management.index'
            )
            ->with(
                'success',
                'Created Successfully'
            );
    }
}
