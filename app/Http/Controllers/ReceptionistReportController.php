<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Staff;
use App\Models\Department;
use App\Models\Token;
use App\Models\Bed;
use App\Models\ReceptionistBilling;
use App\Models\IPDAdmission;
use Carbon\Carbon;
class ReceptionistReportController extends Controller
{
 
public function registration(Request $request)
{
    $query = Patient::query();

    // Filter: Patient Name
    if ($request->patient) {
        $query->where(function ($q) use ($request) {
            $q->where('first_name', 'like', '%' . $request->patient . '%')
              ->orWhere('last_name', 'like', '%' . $request->patient . '%');
        });
    }

    //  Filter: Date (assuming created_at = registration time)
    if ($request->date) {
        $query->whereDate('created_at', $request->date);
    }

    //  Pagination (10 per page)
    $patients = $query->latest()->paginate(10);

    return view('admin.receptionist.reports.registration', compact('patients'));
}

  

public function appointment(Request $request)
{
    $query = Appointment::with(['patient', 'doctor', 'department']);

    //  Filter: Patient
    if ($request->patient) {
        $query->whereHas('patient', function ($q) use ($request) {
            $q->where('first_name', 'like', '%' . $request->patient . '%')
              ->orWhere('last_name', 'like', '%' . $request->patient . '%');
        });
    }

    //  Filter: Doctor
    if ($request->doctor) {
        $query->where('doctor_id', $request->doctor);
    }

    //  Filter: Date
    if ($request->date) {
        $query->whereDate('appointment_date', $request->date);
    }

    //  Pagination
    $appointments = $query->latest()->paginate(10);

$doctors = Staff::all();
$departments = Department::all();

return view('admin.receptionist.reports.appointment', compact('appointments','doctors','departments'));
}

public function token(Request $request)
{
    $query = Token::with(['appointment.patient', 'appointment.doctor']);

    //  Filter: Patient
    if ($request->patient) {
        $query->whereHas('appointment.patient', function ($q) use ($request) {
            $q->where('first_name', 'like', '%' . $request->patient . '%')
              ->orWhere('last_name', 'like', '%' . $request->patient . '%');
        });
    }

    //  Filter: Date (based on token created_at)
    if ($request->date) {
        $query->whereDate('created_at', $request->date);
    }

    $tokens = $query->latest()->paginate(10);

    return view('admin.receptionist.reports.token', compact('tokens'));
}


public function collection(Request $request)
{
    $query = ReceptionistBilling::with('patient');

    //  Patient filter
    if ($request->patient) {
        $query->whereHas('patient', function ($q) use ($request) {
            $q->where('first_name', 'like', '%' . $request->patient . '%')
              ->orWhere('last_name', 'like', '%' . $request->patient . '%');
        });
    }

    //  Payment mode filter
    if ($request->payment_mode) {
        $query->where('payment_mode', $request->payment_mode);
    }

    //  Date filter
    if ($request->date) {
        $query->whereDate('created_at', $request->date);
    }

    $collections = $query->latest()->paginate(10);

    return view('admin.receptionist.reports.collection', compact('collections'));
}

public function admission(Request $request)
{
    $query = IPDAdmission::with(['patient', 'department', 'payments','bed']);

    //  Patient filter
    if ($request->patient) {
        $query->whereHas('patient', function ($q) use ($request) {
            $q->where('first_name', 'like', '%' . $request->patient . '%')
              ->orWhere('last_name', 'like', '%' . $request->patient . '%');
        });
    }

    //  Department filter
    if ($request->department) {
        $query->where('department_id', $request->department);
    }

    //  Date filter
    if ($request->date) {
        $query->whereDate('admission_date', $request->date);
    }

    $admissions = $query->latest()->paginate(10);
    $departments = Department::all();
    $beds = Bed::all();
    return view('admin.receptionist.reports.admission', compact('admissions','departments','beds'));
}

//API
 public function apiRegistration(Request $request)
    {
        $query = Patient::query();

        if ($request->filled('patient')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->patient}%")
                  ->orWhere('last_name', 'like', "%{$request->patient}%");
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $data = $query->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    // ===============================
    // APPOINTMENT REPORT API
    // ===============================
    public function apiAppointment(Request $request)
    {
        $query = Appointment::with(['patient','doctor','department']);

        if ($request->filled('patient')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('first_name','like',"%{$request->patient}%")
                  ->orWhere('last_name','like',"%{$request->patient}%");
            });
        }

        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        $data = $query->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    // ===============================
    // TOKEN REPORT API
    // ===============================
    public function apiToken(Request $request)
    {
        $query = Token::with(['appointment.patient','appointment.doctor']);

        // ✅ ADD THIS (PATIENT FILTER)
        if ($request->filled('patient')) {
            $query->whereHas('appointment.patient', function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->patient}%")
                ->orWhere('last_name', 'like', "%{$request->patient}%");
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $data = $query->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    // ===============================
    // COLLECTION REPORT API
    // ===============================
    public function apiCollection(Request $request)
    {
        $query = ReceptionistBilling::with('patient');

        if ($request->filled('patient')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('first_name','like',"%{$request->patient}%")
                  ->orWhere('last_name','like',"%{$request->patient}%");
            });
        }

        if ($request->filled('payment_mode')) {
            $query->where('payment_mode', $request->payment_mode);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $data = $query->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    // ===============================
    // ADMISSION REPORT API
    // ===============================
    public function apiAdmission(Request $request)
    {
        $query = IPDAdmission::with([
            'patient',
            'department',
            'bed',
            'payments'
        ]);

        if ($request->filled('patient')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('first_name','like',"%{$request->patient}%")
                  ->orWhere('last_name','like',"%{$request->patient}%");
            });
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('admission_date', $request->date);
        }

        $data = $query->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
}
