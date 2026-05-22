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
 public function index(Request $request)
{
    $query = PerformanceReview::query();

    // SEARCH
    if ($request->search) {

        $query->where(function ($q) use ($request) {

            $q->where(
                'employee_id',
                'like',
                '%' . $request->search . '%'
            )

            ->orWhere(
                'employee_name',
                'like',
                '%' . $request->search . '%'
            )

            ->orWhere(
                'department',
                'like',
                '%' . $request->search . '%'
            );
        });
    }

    // STATUS FILTER
    if ($request->review_status) {

        $query->where(
            'review_status',
            $request->review_status
        );
    }

    // RATING FILTER
    if ($request->rating) {

        $query->where(
            'rating',
            $request->rating
        );
    }

    $records = $query
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view(
        'hr.performance_management.index',
        compact('records')
    );
}

    // SHOW
public function show($id)
{
    $record = PerformanceReview::findOrFail($id);

    return view(
        'hr.performance_management.show',
        compact('record')
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

    'employee_id' =>

        'required|string|max:255',

    'employee_name' =>

        'required|string|max:255',

    'department' =>

        'required|string|max:255',

    'reviewer_name' =>

        'required|string|max:255',

    'review_date' =>

        'required|date',

    'rating' =>

        'required|integer|min:1|max:5',
        'review_status' =>

    'nullable|in:Pending,Reviewed,Approved',

    'kpi_name' =>

        'nullable|string|max:255',

    'kpi_score' =>

        'nullable|numeric|min:0|max:100',

    'target_value' =>

        'nullable|numeric|min:0',

    'achieved_value' =>

        'nullable|numeric|min:0',

    'review_comments' =>

        'nullable|string|max:1000',
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

           'review_status' =>

    $request->review_status ?? 'Pending',

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
// EDIT PAGE
public function edit($id)
{
    $record = PerformanceReview::findOrFail($id);

    $employees = Staff::with('department')
        ->where('status', 'Active')
        ->orderBy('employee_id')
        ->get();

    return view(
        'hr.performance_management.edit',
        compact(
            'record',
            'employees'
        )
    );
}
// UPDATE
public function update(Request $request, $id)
{
    $record = PerformanceReview::findOrFail($id);

  $request->validate([

    'employee_id' =>

        'required|string|max:255',

    'employee_name' =>

        'required|string|max:255',

    'department' =>

        'required|string|max:255',

    'reviewer_name' =>

        'required|string|max:255',

    'review_date' =>

        'required|date',

    'rating' =>

        'required|integer|min:1|max:5',
    'review_status' =>

    'nullable|in:Pending,Reviewed,Approved',

    'kpi_name' =>

        'nullable|string|max:255',

    'kpi_score' =>

        'nullable|numeric|min:0|max:100',

    'target_value' =>

        'nullable|numeric|min:0',

    'achieved_value' =>

        'nullable|numeric|min:0',

    'review_comments' =>

        'nullable|string|max:1000',
]);

    $record->update([

        'employee_id' => $request->employee_id,

        'employee_name' => $request->employee_name,

        'department' => $request->department,

        'reviewer_name' => $request->reviewer_name,

        'review_date' => $request->review_date,

        'rating' => $request->rating,

        'review_comments' =>
            $request->review_comments,

        'review_status' =>
            $request->review_status,

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

            ($record->action_history ?? '')

            . "\nUpdated on "

            . now(),
    ]);

    return redirect()
        ->route(
            'hr.performance-management.index'
        )
        ->with(
            'success',
            'Updated Successfully'
        );
}

// DELETE
public function destroy($id)
{
    $record = PerformanceReview::findOrFail($id);

    $record->delete();

    return redirect()
        ->route(
            'hr.performance-management.index'
        )
        ->with(
            'success',
            'Deleted Successfully'
        );
}
// DELETED RECORDS
public function deleted()
{
    $records = PerformanceReview::onlyTrashed()
        ->latest()
        ->paginate(10);

    return view(
        'hr.performance_management.deleted',
        compact('records')
    );
}

// RESTORE
public function restore($id)
{
    $record = PerformanceReview::onlyTrashed()
        ->findOrFail($id);

    $record->restore();

    return redirect()
        ->route(
            'hr.performance-management.deleted'
        )
        ->with(
            'success',
            'Record Restored Successfully'
        );
}

// FORCE DELETE
public function forceDelete($id)
{
    $record = PerformanceReview::onlyTrashed()
        ->findOrFail($id);

    $record->forceDelete();

    return redirect()
        ->route(
            'hr.performance-management.deleted'
        )
        ->with(
            'success',
            'Record Permanently Deleted'
        );
}
   
}
