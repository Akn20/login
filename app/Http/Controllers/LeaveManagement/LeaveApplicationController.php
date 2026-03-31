<?php

namespace App\Http\Controllers\LeaveManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveApplication;
use App\Models\LeaveType;
use App\Models\Staff;
use Carbon\Carbon;
use App\Models\weekends;
use Illuminate\Support\Facades\DB;

class LeaveApplicationController extends Controller
{

    public function index()
    {
        $applications = LeaveApplication::with(['staff', 'leaveType'])
            ->latest()
            ->get();

        foreach ($applications as $application) {

            $usedLeaves = LeaveApplication::where('staff_id', $application->staff_id)
                ->where('leave_type_id', $application->leave_type_id)
                ->where('status', 'approved')
                ->sum('leave_days');

            $application->balance_deducted = $usedLeaves;

            $pendingLeaves = LeaveApplication::where('staff_id', $application->staff_id)
                ->where('leave_type_id', $application->leave_type_id)
                ->where('status', 'pending')
                ->sum('leave_days');

            $application->pending_leave = $pendingLeaves;
        }

        return view(
            'admin.Leave_Management.leave_application.index',
            compact('applications')
        );
    }

    public function create()
    {
        $leaveTypes = LeaveType::whereNull('deleted_at')->get();

        $staff = Staff::findOrFail(5);

        $leaveBalances = [];

        foreach ($leaveTypes as $type) {

            $credit = DB::table('leave_adjustments')
                ->where('staff_id', $staff->id)
                ->where('leave_type_id', $type->id)
                ->sum('credit');

            $debit = DB::table('leave_adjustments')
                ->where('staff_id', $staff->id)
                ->where('leave_type_id', $type->id)
                ->sum('debit');

            $balance = $credit - $debit;

            $leaveBalances[$type->display_name] = $balance;
        }

        return view(
            'admin.Leave_Management.leave_application.create',
            compact('leaveTypes', 'leaveBalances')
        );
    }


    public function store(Request $request)
    {

        $request->validate([
            'leave_type_id' => 'required',
            'leave_duration' => 'required|in:full_day,first_half,second_half',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'reason' => 'nullable|string|max:500',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);


        $staff = Staff::findOrFail(5);

        if (!$staff) {
            return back()->with('error', 'No staff found');
        }

        /*
        |--------------------------------------------------------------------------
        | Calculate Leave Days
        |--------------------------------------------------------------------------
        */

        $from = Carbon::parse($request->from_date);
        $to = Carbon::parse($request->to_date);

        $leaveType = LeaveType::find($request->leave_type_id);

        /*
        |--------------------------------------------------------------------------
        | Past Date Validation
        |--------------------------------------------------------------------------
        */

        if ($from->lt(Carbon::today())) {

            return back()->withErrors([
                'from_date' => 'You cannot apply leave for past dates'
            ])->withInput();
        }



        /*Overlapping validation */

        $overlap = LeaveApplication::where('staff_id', $staff->id)
            ->where('status', '!=', 'rejected')
            ->where(function ($query) use ($from, $to) {

                $query->whereBetween('from_date', [$from, $to])
                    ->orWhereBetween('to_date', [$from, $to])
                    ->orWhere(function ($q) use ($from, $to) {

                        $q->where('from_date', '<=', $from)
                            ->where('to_date', '>=', $to);

                    });

            })
            ->exists();

        if ($overlap) {

            return back()->withErrors([
                'leave_overlap' => 'You already have a leave applied for selected dates'
            ])->withInput();
        }



        $weekend = weekends::active()->first();
        $weekendDays = $weekend ? $weekend->days : [];

        $days = 0;
        $current = $from->copy();

        $type = strtolower($leaveType->sandwich_applies_on ?? '');

        while ($current <= $to) {

            $isWeekend = in_array($current->format('l'), $weekendDays);

            $isHoliday = DB::table('holidays')
                ->where('status', 1)
                ->whereDate('start_date', '<=', $current->toDateString())
                ->whereDate('end_date', '>=', $current->toDateString())
                ->exists();

            $isMiddleDay = $current->gt($from) && $current->lt($to);

            if ($leaveType->sandwich_enabled && $isMiddleDay) {

                if (
                    ($type == 'weekend' && $isWeekend) ||
                    ($type == 'holiday' && $isHoliday) ||
                    ($type == 'both' && ($isWeekend || $isHoliday))
                ) {
                    $days++;
                    $current->addDay();
                    continue;
                }
            }

            if ($isHoliday) {

                if ($leaveType->count_holidays) {
                    $days++;
                }

            } elseif ($isWeekend) {

                if ($leaveType->count_weekends) {
                    $days++;
                }

            } else {

                $days++;

            }

            $current->addDay();
        }
        if ($request->leave_duration !== 'full_day') {

            if (!$leaveType->allow_half_day) {

                return back()->withErrors([
                    'leave_duration' => 'Half day is not allowed for this leave type'
                ])->withInput();

            }

            $days = $leaveType->min_leave_unit ?? 0.5;

        }


        /*
        |--------------------------------------------------------------------------
        | Max Continuous Leave Validation
        |--------------------------------------------------------------------------
        */

        if ($leaveType->max_continuous_days && $days > $leaveType->max_continuous_days) {

            return back()->withErrors([
                'leave_days' => 'Maximum continuous leave allowed is ' . $leaveType->max_continuous_days . ' days'
            ])->withInput();

        }


        /*
        |--------------------------------------------------------------------------
        | Get Leave Mapping FIRST
        |--------------------------------------------------------------------------
        */

        $mapping = DB::table('leave_mappings')
            ->where('leave_type_id', $request->leave_type_id)
            ->first();

        $minLeave = $mapping->min_leave_per_application ?? 0;
        $maxLeave = $mapping->max_leave_per_application ?? 999;

        /*
        |--------------------------------------------------------------------------
        | Minimum Leave Validation
        |--------------------------------------------------------------------------
        */
        if ($days < $minLeave && $days != $leaveType->min_leave_unit) {

            return back()->withErrors([
                'leave_days' => 'Minimum leave per application is ' . $minLeave . ' day(s)'
            ])->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Maximum Leave Validation
        |--------------------------------------------------------------------------
        */

        if ($days > $maxLeave) {

            return back()->withErrors([
                'leave_days' => 'Maximum leave per application is ' . $maxLeave . ' day(s)'
            ])->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Leave Balance Validation (Using leave_adjustments)
        |--------------------------------------------------------------------------
        */

        $credit = DB::table('leave_adjustments')
            ->where('staff_id', $staff->id)
            ->where('leave_type_id', $request->leave_type_id)
            ->sum('credit');

        $debit = DB::table('leave_adjustments')
            ->where('staff_id', $staff->id)
            ->where('leave_type_id', $request->leave_type_id)
            ->sum('debit');

        $currentBalance = $credit - $debit;

        $balanceBefore = $currentBalance;
        $balanceAfter = $currentBalance - $days;

        if ($days > $currentBalance) {

            return back()->withErrors([
                'leave_days' => 'Leave exceeds available balance. Remaining: ' . $currentBalance . ' days'
            ])->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | File Upload
        |--------------------------------------------------------------------------
        */

        $attachment = null;

        if ($request->hasFile('attachment')) {

            $file = $request->file('attachment');

            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('uploads/leave'), $filename);

            $attachment = 'uploads/leave/' . $filename;
        }


        /*
        |--------------------------------------------------------------------------
        | Save Leave Application
        |--------------------------------------------------------------------------
        */

        LeaveApplication::create([
            'staff_id' => $staff->id,
            'leave_type_id' => $request->leave_type_id,
            'leave_duration' => $request->leave_duration,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'leave_days' => $days,
            'balance_before' => $balanceBefore,
            'balance_after' => $balanceAfter,
            'reason' => $request->reason,
            'attachment' => $attachment,
            'status' => 'pending'
        ]);


        return redirect()
            ->route('hr.leave-application.index')
            ->with('success', 'Leave applied successfully');
    }


    public function show($id)
    {
        $application = LeaveApplication::with(['staff', 'leaveType'])
            ->findOrFail($id);

        return view(
            'admin.Leave_Management.leave_application.show',
            compact('application')
        );
    }


    public function withdraw($id)
    {
        $application = LeaveApplication::findOrFail($id);

        $application->update([
            'status' => 'withdrawn'
        ]);

        return redirect()
            ->back()
            ->with('success', 'Leave withdrawn successfully');
    }

}