<?php

namespace App\Http\Controllers\Admin\Radiology;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ScanRequest;
use App\Models\ScanType;
use App\Models\Patient;
use App\Models\User;

class ScanRequestController extends Controller
{
    public function index()
    {
        $requests = ScanRequest::with(['patient','scanType','doctor'])->latest()->get();
        return view('admin.radiology.scan-requests.index', compact('requests'));
    }

    public function create()
    {
        $patients = Patient::all();
        $scanTypes = ScanType::where('status','Active')->get();
        $doctors = User::join('staff', 'users.id', '=', 'staff.user_id')
        ->join('roles', 'staff.role_id', '=', 'roles.id')
        ->where('roles.name', 'doctor') // or 'Doctor'
        ->select('users.*')
        ->get();

        return view('admin.radiology.scan-requests.create', compact('patients','scanTypes','doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'scan_type_id' => 'required',
            'body_part' => 'required',
            'priority' => 'required',
            'doctor_id' => 'required'
        ]);

        ScanRequest::create($request->all());

        return redirect()->route('admin.radiology.scan-requests.index')
            ->with('success','Scan Request Created');
    }

   public function edit($id)
{
    $requestData = ScanRequest::findOrFail($id);

    $patients = Patient::all();
    $scanTypes = ScanType::where('status','Active')->get();

    // ✅ FIXED DOCTOR QUERY
    $doctors = User::join('staff', 'users.id', '=', 'staff.user_id')
        ->join('roles', 'staff.role_id', '=', 'roles.id')
        ->where('roles.name', 'doctor')
        ->select('users.*')
        ->get();

    return view('admin.radiology.scan-requests.edit', compact(
        'requestData','patients','scanTypes','doctors'
    ));
}

    public function update(Request $request, $id)
    {
        $data = ScanRequest::findOrFail($id);

        $data->update($request->all());

        return redirect()->route('admin.radiology.scan-requests.index')
            ->with('success','Updated Successfully');
    }

    public function destroy($id)
    {
        ScanRequest::findOrFail($id)->delete();

        return back()->with('success','Deleted');
    }
}