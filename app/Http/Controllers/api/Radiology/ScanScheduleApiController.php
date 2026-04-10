<?php

namespace App\Http\Controllers\Api\Radiology;

use App\Http\Controllers\Controller;
use App\Models\ScanUpload;
use App\Models\ScanRequest;
use Illuminate\Http\Request;

class ScanScheduleApiController extends Controller
{
   public function store(Request $request)
{
    \App\Models\ScanSchedule::create([
        'scan_request_id' => $request->scan_request_id,
        'scan_date' => $request->date,
        'scan_time' => $request->time,
        'technician_id' => null
    ]);

    // update status
    \App\Models\ScanRequest::where(
        'id',
        $request->scan_request_id
    )->update([
        'status' => 'Scheduled'
    ]);

    return response()->json([
        'message' => 'Scheduled successfully'
    ]);
}
public function index()
{
    // 1) Pending requests
    $pendingRequests = \DB::table('scan_requests')
        ->leftJoin(
            'patients',
            'scan_requests.patient_id',
            '=',
            'patients.id'
        )
        ->whereRaw("LOWER(scan_requests.status) = 'pending'")
        ->select(
            'scan_requests.id',

            \DB::raw(
                "CONCAT(patients.first_name, ' ', patients.last_name) as patientName"
            ),

            'scan_requests.body_part as bodyPart',
            'scan_requests.status'
        )
        ->get();

    // 2) Scheduled scans
    $scheduledScans = \DB::table('scan_schedules')
        ->leftJoin(
            'scan_requests',
            'scan_schedules.scan_request_id',
            '=',
            'scan_requests.id'
        )
        ->leftJoin(
            'patients',
            'scan_requests.patient_id',
            '=',
            'patients.id'
        )
        ->select(
            'scan_schedules.id',

            'scan_schedules.scan_request_id as scanRequestId',

            \DB::raw(
                "CONCAT(patients.first_name, ' ', patients.last_name) as patientName"
            ),

            'scan_requests.body_part as bodyPart',

            'scan_schedules.scan_date as date',

            'scan_schedules.scan_time as time',

            'scan_requests.status'
        )
        ->get();

    return response()->json([
        'pendingRequests' => $pendingRequests,
        'scheduledScans' => $scheduledScans,
    ]);
}
public function destroy($id)
{
    \App\Models\ScanSchedule::findOrFail($id)->delete();

    return response()->json([
        'message' => 'Scheduled scan deleted successfully'
    ]);
}
public function update(Request $request, $id)
{
    $schedule = \App\Models\ScanSchedule::findOrFail($id);

    $schedule->update([
        'scan_date' => $request->date,
        'scan_time' => $request->time,
    ]);

    return response()->json([
        'message' => 'Scheduled scan updated successfully'
    ]);
}
}