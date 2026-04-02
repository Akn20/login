<?php

namespace App\Http\Controllers\LeaveManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveApplication;
use App\Models\Compoff;
use App\Models\Department;

class LeaveReportController extends Controller
{
    public function index(Request $request)
    {
        $query = LeaveApplication::with([
            'staff.department',
            'leaveType',
            'approvals.user'
        ]);

        // Employee filter
        if ($request->employee) {
            $query->whereHas('staff', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->employee}%");
            });
        }

        // Department filter (NEW)
        if ($request->department) {
            $query->whereHas('staff', function ($q) use ($request) {
                $q->where('department_id', $request->department);
            });
        }

        //  DATE FILTER (FIXED)
        if ($request->from_date && $request->to_date) {

            if ($request->from_date > $request->to_date) {
                return back()->with('error', 'From Date cannot be greater than To Date');
            }

            $query->whereBetween('from_date', [$request->from_date, $request->to_date]);

        } elseif ($request->from_date) {

            $query->whereDate('from_date', '>=', $request->from_date);

        } elseif ($request->to_date) {

            $query->whereDate('to_date', '<=', $request->to_date);
        }

        //  Status filter
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $reports = $query->latest()->paginate(10);

       $compoffs = Compoff::with('employee')->get()->map(function ($comp) {

    $leave = \App\Models\LeaveApplication::where('staff_id', $comp->employee_id)
        ->whereHas('leaveType', function ($q) {
            $q->where('display_name', 'Comp Off');
        })
        ->latest()
        ->first();

    $comp->applied_date = $leave ? $leave->created_at : null;

    return $comp;
});

        //  Departments for dropdown
        $departments = Department::all();

        return view('admin.Leave_Management.leave_report.index',
            compact('reports', 'compoffs', 'departments'));
    }


    //  API for leave report
   /*public function apiIndex(Request $request)
{
    $query = LeaveApplication::with([
        'staff.department',
        'leaveType',
        'approvals.user'
    ]);

    // Employee filter
    if ($request->employee) {
        $query->whereHas('staff', function ($q) use ($request) {
            $q->where('name', 'like', "%{$request->employee}%");
        });
    }

    // Department filter
    if ($request->department) {
        $query->whereHas('staff', function ($q) use ($request) {
            $q->where('department_id', $request->department);
        });
    }

    // DATE FILTER (FULL FIX)
    if ($request->from_date && $request->to_date) {

        if ($request->from_date > $request->to_date) {
            return response()->json([
                'status' => false,
                'message' => 'From Date cannot be greater than To Date'
            ], 400);
        }

        $query->whereBetween('from_date', [$request->from_date, $request->to_date]);

    } elseif ($request->from_date) {

        $query->whereDate('from_date', '>=', $request->from_date);

    } elseif ($request->to_date) {

        $query->whereDate('to_date', '<=', $request->to_date);
    }

    // Status filter
    if ($request->status) {
        $query->where('status', $request->status);
    }

    $reports = $query->latest()->get();

    // CLEAN RESPONSE (BEST FOR MOBILE)
    return response()->json([
        'status' => true,
        'data' => $reports->map(function ($leave) {
            return [
                'employee' => $leave->staff->name ?? null,
                'department' => $leave->staff->department->department_name ?? null,
                'leave_type' => $leave->leaveType->display_name ?? null,
                'from_date' => $leave->from_date,
                'to_date' => $leave->to_date,
                'status' => $leave->status,
                'approved_by' => optional($leave->approvals->last())->user->name,
                'days' => $leave->leave_days
            ];
        })
    ]);
}*/
public function apiIndex(Request $request)
{
    try {
        $query = LeaveApplication::with([
            'staff.department',
            'leaveType',
            'approvals.user'
        ]);

        $reports = $query->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $reports->map(function ($leave) {
                return [
                    'employee' => $leave->staff->name ?? null,
                    'department' => $leave->staff->department->department_name ?? null,
                    'leave_type' => $leave->leaveType->display_name ?? null,
                    'from_date' => $leave->from_date,
                    'to_date' => $leave->to_date,
                    'status' => $leave->status,
                    'approved_by' => optional($leave->approvals->last())->user->name ?? null,
                    'days' => $leave->leave_days
                ];
            })
        ]);

    } catch (\Exception $e) {
        return response()->json([        // 👈 this will tell us exactly what's wrong
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => basename($e->getFile())
        ], 500);
    }
}

    //  API for compoff report
 public function apiCompoff(Request $request)
{
    $query = Compoff::with('employee');

    // Optional employee filter
    if ($request->employee_id) {
        $query->where('employee_id', $request->employee_id);
    }

    // Optional date filter
    if ($request->from_date && $request->to_date) {
        $query->whereBetween('worked_on', [$request->from_date, $request->to_date]);
    }

    $compoffs = $query->latest()->get();

    return response()->json([
        'status' => true,
        'data' => $compoffs->map(function ($comp) {
            return [
                'employee' => $comp->employee->name ?? null,
                'worked_on' => $comp->worked_on,
                'applied_date' => $comp->applied_date,
                'expiry_date' => $comp->expiry_date
            ];
        })
    ]);
}


}