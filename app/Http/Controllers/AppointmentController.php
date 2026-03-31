<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Staff;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

class AppointmentController extends Controller
{

    /* ================= WEB FUNCTIONS ================= */

    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor', 'department'])
            ->latest()
            ->get();

        return view('admin.receptionist.appointments.index', compact('appointments'));
    }


    public function create()
    {
        $patients = Patient::whereNull('deleted_at')->get();

        $departments = Department::whereNull('deleted_at')->get();

        $doctors = Staff::join('roles', 'staff.role_id', '=', 'roles.id')
            ->where('roles.name', 'Doctor')
            ->whereNull('staff.deleted_at')
            ->select('staff.id', 'staff.name', 'staff.department_id')
            ->get();

        return view(
            'admin.Receptionist.appointments.create',
            compact('patients', 'departments', 'doctors')
        );
    }


    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'department_id' => 'required',
            'appointment_date' => 'required',
            'appointment_time' => 'required',
        ]);

        $exists = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->whereNull('deleted_at')
            ->exists();

        if ($exists) {
            return back()->withInput()
                ->with('error', 'Doctor already has an appointment at this time.');
        }

        // Fetch institution automatically
        $institution = \App\Models\Institution::first();

        Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'department_id' => $request->department_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'consultation_fee' => $request->consultation_fee,
            'appointment_status' => $request->appointment_status,
            'institution_id' => $institution->id,   // FIX HERE
            'receptionist_user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment created successfully');
    }


    public function show($id)
    {
        $appointment = Appointment::with(['patient', 'doctor', 'department'])
            ->findOrFail($id);

        return view('admin.Receptionist.appointments.show', compact('appointment'));
    }


    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);

        $patients = Patient::get();
        $departments = Department::get();

        $doctors = Staff::join('roles', 'staff.role_id', '=', 'roles.id')
            ->where('roles.name', 'Doctor')
            ->select('staff.id', 'staff.name')
            ->get();

        return view(
            'admin.Receptionist.appointments.edit',
            compact('appointment', 'patients', 'departments', 'doctors')
        );
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'department_id' => 'required',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required'
        ]);

        $appointment = Appointment::findOrFail($id);

        $appointment->update([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'department_id' => $request->department_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'consultation_fee' => $request->consultation_fee,
            'appointment_status' => $request->appointment_status
        ]);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment updated successfully');
    }


    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);

        $appointment->delete();

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment deleted successfully');
    }


    public function trash()
    {
        $appointments = Appointment::onlyTrashed()->get();

        return view('admin.Receptionist.appointments.trash', compact('appointments'));
    }


    public function restore($id)
    {
        Appointment::withTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.appointments.trash')
            ->with('success', 'Appointment restored');
    }


    public function forceDelete($id)
    {
        Appointment::withTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('admin.appointments.trash')
            ->with('success', 'Appointment permanently deleted');
    }
    public function getDoctors($department_id)
    {
        $doctors = \App\Models\Staff::where('department_id', $department_id)
            ->whereHas('role', function ($query) {
                $query->where('name', 'Doctor');
            })
            ->get(['id', 'name']);

        return response()->json($doctors);
    }


    /* ================= API FUNCTIONS ================= */

    public function apiIndex()
    {
        $appointments = Appointment::with(['patient', 'doctor', 'department'])
            ->latest()
            ->get();

        return ApiResponse::success($appointments, 'Appointments retrieved successfully');
    }

    public function apiShow($id)
    {
        $appointment = Appointment::with(['patient', 'doctor', 'department'])
            ->find($id);

        if (!$appointment) {
            return ApiResponse::error('Appointment not found');
        }

        return ApiResponse::success($appointment, 'Appointment details retrieved successfully');
    }

    public function apiStore(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'department_id' => 'required',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required'
        ]);

        $exists = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->whereNull('deleted_at')
            ->exists();

        if ($exists) {
            return ApiResponse::error('Doctor already has an appointment at this time');
        }

        $institution = \App\Models\Institution::first();

        $appointment = Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'department_id' => $request->department_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'consultation_fee' => $request->consultation_fee,
            'appointment_status' => 'Scheduled',
            'institution_id' => $institution->id
        ]);

        return ApiResponse::success($appointment, 'Appointment created successfully');
    }

    public function apiUpdate(Request $request, $id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return ApiResponse::error('Appointment not found');
        }

        $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'department_id' => 'required',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required'
        ]);

        $appointment->update([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'department_id' => $request->department_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'consultation_fee' => $request->consultation_fee,
            'appointment_status' => $request->appointment_status
        ]);

        return ApiResponse::success($appointment, 'Appointment updated successfully');
    }

    public function apiDestroy($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return ApiResponse::error('Appointment not found');
        }

        $appointment->delete();

        return ApiResponse::success(null, 'Appointment deleted successfully');
    }

    public function apiDoctors($department_id)
    {
        $doctors = Staff::where('department_id', $department_id)
            ->whereHas('role', function ($query) {
                $query->where('name', 'Doctor');
            })
            ->get(['id', 'name']);

        return ApiResponse::success($doctors, 'Doctors retrieved successfully');
    }

    public function apiGetPatients()
    {
        $patients = Patient::select('id', 'first_name', 'last_name')->get();
        return ApiResponse::success($patients, 'Patients retrieved successfully');
    }

    public function apiGetDepartments()
    {
        $departments = Department::select('id', 'department_name as name')->get();
        return ApiResponse::success($departments, 'Departments retrieved successfully');
    }

    public function apiTrash()
    {
        $appointments = Appointment::onlyTrashed()
            ->with(['patient', 'doctor', 'department'])
            ->get();

        return ApiResponse::success($appointments, 'Deleted appointments retrieved successfully');
    }

    public function apiRestore($id)
    {
        $appointment = Appointment::withTrashed()->find($id);

        if (!$appointment) {
            return ApiResponse::error('Appointment not found');
        }

        $appointment->restore();

        return ApiResponse::success($appointment, 'Appointment restored successfully');
    }

    public function apiForceDelete($id)
    {
        $appointment = Appointment::withTrashed()->find($id);

        if (!$appointment) {
            return ApiResponse::error('Appointment not found');
        }

        $appointment->forceDelete();

        return ApiResponse::success(null, 'Appointment permanently deleted');
    }


}