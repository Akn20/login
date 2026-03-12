<?php

use App\Models\User;
use App\Models\Staff;
use App\Models\LeaveRequests;
use App\Models\LeaveType;
use Carbon\Carbon;
use Illuminate\Support\Str;

// Find a user who is manager, hr, or hod
$supervisorUser = User::whereHas('role', function ($q) {
    $q->whereIn('name', ['manager', 'hr', 'hod']);
})->first();

if (!$supervisorUser) {
    echo "No supervisor (manager/hr/hod) found.\n";
    exit;
}

// Find a staff member
$staff = Staff::first();
if (!$staff) {
    echo "No staff found.\n";
    exit;
}

// Assign the user ID of supervisor to the staff's supervisor field
$staff->level1_supervisor_id = $supervisorUser->id;
$staff->level2_supervisor_id = $supervisorUser->id;
$staff->level3_supervisor_id = $supervisorUser->id;
$staff->save();

$leaveType = LeaveType::first();

// Create pending leave requests
LeaveRequests::create([
    'id' => (string) Str::uuid(),
    'employee_id' => $staff->id,
    'leave_type_id' => $leaveType->id ?? null,
    'from_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
    'to_date' => Carbon::now()->addDays(4)->format('Y-m-d'),
    'from_session' => 'Session 1',
    'to_session' => 'Session 2',
    'total_leave_days' => 3,
    'purpose' => 'Family Trip',
    'status' => 'pending',
    'current_approval_level' => 1,
]);

LeaveRequests::create([
    'id' => (string) Str::uuid(),
    'employee_id' => $staff->id,
    'leave_type_id' => $leaveType->id ?? null,
    'from_date' => Carbon::now()->addDays(10)->format('Y-m-d'),
    'to_date' => Carbon::now()->addDays(11)->format('Y-m-d'),
    'from_session' => 'Session 1',
    'to_session' => 'Session 2',
    'total_leave_days' => 2,
    'purpose' => 'Medical Checkup',
    'status' => 'pending',
    'current_approval_level' => 1,
]);

echo "Created 2 leave requests for Staff {$staff->name} supervised by User {$supervisorUser->id}\n";
