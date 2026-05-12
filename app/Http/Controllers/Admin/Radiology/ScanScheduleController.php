<?php

namespace App\Http\Controllers\Admin\Radiology;

use App\Http\Controllers\Controller;
use App\Models\ScanRequest;
use App\Models\ScanSchedule;
use Illuminate\Http\Request;

class ScanScheduleController extends Controller
{
public function index()
{
    $requests = ScanRequest::where('status','Pending')->get();
    $schedules = ScanSchedule::with('request.patient')->get();

    return view('admin.radiology.schedule.index', compact('requests','schedules'));
}
public function store(Request $request)
{
    $request->validate([
        'scan_request_id' => 'required',
        'scan_date' => 'required|date',
        'scan_time' => 'required'
    ]);

   
    $exists = ScanSchedule::where('scan_request_id', $request->scan_request_id)->exists();

    if ($exists) {
        return back()->with('error', 'This scan is already scheduled!');
    }

    ScanSchedule::create([
        'scan_request_id' => $request->scan_request_id,
        'scan_date' => $request->scan_date,
        'scan_time' => $request->scan_time
    ]);

    ScanRequest::where('id', $request->scan_request_id)
        ->update(['status' => 'Scheduled']);

    return back()->with('success', 'Scan Scheduled Successfully');
}

public function edit($id)
{
    $schedule = ScanSchedule::findOrFail($id);
    return view('admin.radiology.schedule.edit', compact('schedule'));
}

public function update(Request $request, $id)
{
    $schedule = ScanSchedule::findOrFail($id);

    $schedule->update([
        'scan_date' => $request->scan_date,
        'scan_time' => $request->scan_time
    ]);

    return redirect()->route('admin.radiology.schedule.index')
        ->with('success', 'Schedule Updated');
}

public function destroy($id)
{
    $schedule = ScanSchedule::findOrFail($id);

    // reset request status
    ScanRequest::where('id', $schedule->scan_request_id)
        ->update(['status' => 'Pending']);

    $schedule->delete();

    return back()->with('success', 'Schedule Deleted');
}

public function quickSchedule(Request $request)
{
    $request->validate([
        'scan_request_id' => 'required'
    ]);

    // ❌ prevent duplicate
    $exists = ScanSchedule::where('scan_request_id', $request->scan_request_id)->exists();

    if ($exists) {
        return back()->with('error', 'Already Scheduled!');
    }

    // ✅ auto date/time (you can customize)
    $date = now()->toDateString();
    $time = now()->addHour()->format('H:i:s');

    ScanSchedule::create([
        'scan_request_id' => $request->scan_request_id,
        'scan_date' => $date,
        'scan_time' => $time
    ]);

    ScanRequest::where('id', $request->scan_request_id)
        ->update(['status' => 'Scheduled']);

    return back()->with('success', 'Scheduled instantly');
}
}
