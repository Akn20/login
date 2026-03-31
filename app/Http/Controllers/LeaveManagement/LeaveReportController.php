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

        //  CompOff (optional: filter by date also)
        $compoffs = Compoff::with('employee')->latest()->get();

        //  Departments for dropdown
        $departments = Department::all();

        return view('admin.Leave_Management.leave_report.index',
            compact('reports', 'compoffs', 'departments'));
    }
}