<?php

namespace App\Http\Controllers;

use App\Models\HospitalWorkingHour;
use Illuminate\Http\Request;

class HospitalWorkingHourController extends Controller
{
    public function index()
    {
        $workingHours = HospitalWorkingHour::all();

        return view(
            'hospital_working_hours.index',
            compact('workingHours')
        );
    }

    public function create()
    {
        return view('hospital_working_hours.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'opening_time' => 'required',
            'closing_time' => 'required'
        ]);

        HospitalWorkingHour::create([
            'hospital_id' => 1,
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,
            'break_start' => $request->break_start,
            'break_end' => $request->break_end,
            'emergency_24x7' => $request->has('emergency_24x7'),
            'status' => $request->status
        ]);

        return redirect()
            ->route('hospital-working-hours.index')
            ->with('success','Working Hours Added Successfully');
    }

    public function show($id)
    {
        $workingHour = HospitalWorkingHour::findOrFail($id);

        return view(
            'hospital_working_hours.show',
            compact('workingHour')
        );
    }

    public function edit($id)
    {
        $workingHour = HospitalWorkingHour::findOrFail($id);

        return view(
            'hospital_working_hours.edit',
            compact('workingHour')
        );
    }

    public function update(Request $request, $id)
    {
        $workingHour = HospitalWorkingHour::findOrFail($id);

        $request->validate([
            'opening_time' => 'required',
            'closing_time' => 'required'
        ]);

        $workingHour->update([
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,
            'break_start' => $request->break_start,
            'break_end' => $request->break_end,
            'emergency_24x7' => $request->has('emergency_24x7'),
            'status' => $request->status
        ]);

        return redirect()
            ->route('hospital-working-hours.index')
            ->with('success','Working Hours Updated Successfully');
    }

    public function destroy($id)
    {
        $workingHour = HospitalWorkingHour::findOrFail($id);

        $workingHour->delete();

        return redirect()
            ->route('hospital-working-hours.index')
            ->with('success','Working Hours Deleted Successfully');
    }
}