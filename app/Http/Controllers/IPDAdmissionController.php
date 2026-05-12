<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Staff;
use App\Models\Roles;
use App\Models\Room;
use App\Models\Department;
use App\Models\Bed;
use App\Models\Ward;
use App\Models\IPDAdmission;
use App\Models\IPDPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class IPDAdmissionController extends Controller
{
    /**
     * Display IPD Admission List
     */
public function index(Request $request)
{
    $query = IPDAdmission::with([
        'patient',
        'doctor',
        'department',
        'bed',
        'ward'
    ]);

    // Filter
    if ($request->date) {
        $query->whereDate('admission_date', $request->date);
    }

  
    if ($request->status) {
        $query->where('status', strtolower($request->status));
    }

   
    if ($request->search) {
        $search = $request->search;

        $query->whereHas('patient', function ($q) use ($search) {
            $q->where('first_name', 'like', "%$search%")
              ->orWhere('last_name', 'like', "%$search%");
        });
    }

    // Pagination
   $ipds = $query->latest()->paginate(10)->withQueryString();

    return view('admin.receptionist.ipd.index', compact('ipds'));
}

    /**
     * Show Create Form
     */


public function create()
{
    $patients = Patient::all();
     //  Get doctor role ID
    $doctorRole = Roles::where('name', 'doctor')->first();

    //  Get staff with doctor role
    $doctors = Staff::where('role_id', $doctorRole->id)->get();

    $departments = Department::all();
    $beds = Bed::all();
    $rooms =Room::all();
    $wards= Ward::all();
    return view('admin.receptionist.ipd.create', compact(
        'patients',
        'doctors',
        'departments',
        'beds',
        'wards',
        'rooms'
    ));
}

    /**
     * Store Admission
     */


public function store(Request $request)
{
    $request->validate([
        'patient_id' => 'required',
        'doctor_id' => 'required',
        'bed_id' => 'required',
        'payment_mode' => 'required_if:advance_amount,>,0'
    ]);

    DB::beginTransaction();

    try {

        // 🚫 Prevent duplicate admission
        $exists = IPDAdmission::where('patient_id', $request->patient_id)
            ->where('status', 'active')
            ->exists();

        if ($exists) {
            return back()->with('error', 'Patient already admitted');
        }

        // 🚫 Prevent occupied bed
        $bed = Bed::where('id', $request->bed_id)->first();

        if ($bed->status == 'occupied') {
            return back()->with('error', 'Bed already occupied');
        }

        // ✅ Create Admission
        $admission = IPDAdmission::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'department_id' => $request->department_id,
            'ward_id' => $request->ward_id,
            'room_id' => $request->room_id,
            'bed_id' => $request->bed_id,
            'admission_type' => $request->admission_type,
            'admission_date' => $request->admission_date ?? now(),
            'advance_amount' => $request->advance_amount ?? 0,
            'insurance_flag' => $request->insurance_flag ?? 0,
            'insurance_provider' => $request->insurance_provider,
            'policy_number' => $request->policy_number,
            'notes' => $request->notes,
            'created_by' => Auth::id(),
        ]);

        // 💳 Save Payment
        if ($request->advance_amount > 0) {
            IPDPayment::create([
                'patient_id' => $request->patient_id,
                'ipd_id' => $admission->id,
                'amount' => $request->advance_amount,
                'payment_mode' => $request->payment_mode,
                'transaction_type' => 'advance'
            ]);
        }

        // 🛏️ Update Bed
        $bed->update(['status' => 'occupied']);

        DB::commit();

        return redirect()->route('admin.receptionist.ipd.index')
            ->with('success', 'Admission Created Successfully');

    } catch (\Exception $e) {

        DB::rollback();

        return back()->with('error', $e->getMessage());
    }
}

    /**
     * View Admission
     */
    public function view($id)
{
    $ipd = IPDAdmission::with([
        'patient',
        'doctor',
        'department',
        'ward',
        'room',
        'bed'
    ])->findOrFail($id);

    return view('admin.receptionist.ipd.view', compact('ipd'));
}

    /**
     * Edit Admission
     */
    public function edit($id)
{
    $ipd = IPDAdmission::findOrFail($id);

    // doctors (from staff)
    $doctorRole = Roles::where('name', 'doctor')->first();
    $doctors = Staff::where('role_id', $doctorRole->id)->get();

    $departments = Department::all();
    $beds = Bed::all();
    $rooms = Room::all();
    $wards = Ward::all();

    return view('admin.receptionist.ipd.edit', compact(
        'ipd',
        'doctors',
        'departments',
        'beds',
        'rooms',
        'wards'
    ));
}

    /**
     * Update Admission
     */

public function update(Request $request, $id)
{
    DB::beginTransaction();

    try {

        $ipd = IPDAdmission::findOrFail($id);

        // 🔴 If discharge button clicked
        if ($request->action === 'discharge') {

            if ($ipd->status === 'discharged') {
                return back()->with('error', 'Already discharged');
            }

            // 🛏️ Free bed
            if ($ipd->bed_id) {
                Bed::where('id', $ipd->bed_id)
                    ->update(['status' => 'available']);
            }

            // ✅ Update status
            $ipd->update([
                'status' => 'discharged',
                'discharge_date' => now()
            ]);

            DB::commit();

            return redirect()->route('admin.receptionist.ipd.index')
                ->with('success', 'Patient discharged successfully');
        }

        // 🔵 Normal update flow
        $request->validate([
            'doctor_id' => 'required',
            'bed_id' => 'required',
        ]);

        // 🛏️ Bed logic
        if ($ipd->bed_id != $request->bed_id) {

            $newBed = Bed::findOrFail($request->bed_id);

            if ($newBed->status === 'occupied') {
                return back()->with('error', 'Bed already occupied');
            }

            // free old bed
            if ($ipd->bed_id) {
                Bed::where('id', $ipd->bed_id)
                    ->update(['status' => 'available']);
            }

            // assign new bed
            $newBed->update(['status' => 'occupied']);
        }

        // update record
        $ipd->update([
            'doctor_id' => $request->doctor_id,
            'department_id' => $request->department_id,
            'ward_id' => $request->ward_id,
            'room_id' => $request->room_id,
            'bed_id' => $request->bed_id,
            'admission_type' => $request->admission_type,
            'admission_date' => $request->admission_date,
            'insurance_flag' => $request->insurance_flag ?? 0,
            'insurance_provider' => $request->insurance_provider,
            'policy_number' => $request->policy_number,
            'notes' => $request->notes,
        ]);

        DB::commit();

        return redirect()->route('admin.receptionist.ipd.index')
            ->with('success', 'Updated successfully');

    } catch (\Exception $e) {

        DB::rollback();

        return back()->with('error', $e->getMessage());
    }
}

    /**
     * Print Admission
     */
    public function print($id)
{
    $ipd = IPDAdmission::with([
        'patient',
        'doctor',
        'department',
        'ward',
        'room',
        'bed'
    ])->findOrFail($id);

    return view('admin.receptionist.ipd.print', compact('ipd'));
}

public function getPatient($id)
{
    $patient = Patient::find($id);

    return response()->json($patient);
}


//API
public function apiIndex(Request $request)
{
    $query = IPDAdmission::with(['patient','doctor','department','ward','room','bed']);

    if ($request->date) {
        $query->whereDate('admission_date', $request->date);
    }

    if ($request->status) {
        $query->where('status', $request->status);
    }

    if ($request->search) {
        $search = $request->search;

        $query->whereHas('patient', function ($q) use ($search) {
            $q->where('first_name', 'like', "%$search%")
              ->orWhere('last_name', 'like', "%$search%");
        });
    }

    $ipds = $query->latest()->get()->map(function ($ipd) {
        return [
            'id' => $ipd->id,
            'admission_id' => $ipd->admission_id,
            'patient_name' => $ipd->patient->first_name ?? '',
            'doctor' => $ipd->doctor->name ?? '',
            'status' => $ipd->status,
            'admission_date' => $ipd->admission_date,
        ];
    });

    return response()->json([
        'status' => true,
        'data' => $ipds
    ]);
}
public function apiStore(Request $request)
{
    DB::beginTransaction();

    try {

        $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'bed_id' => 'required'
        ]);

        // prevent duplicate admission
        $exists = IPDAdmission::where('patient_id', $request->patient_id)
            ->where('status', 'active')
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'Patient already admitted'
            ], 400);
        }

        $bed = Bed::findOrFail($request->bed_id);

        if ($bed->status === 'occupied') {
            return response()->json([
                'status' => false,
                'message' => 'Bed already occupied'
            ], 400);
        }

        $ipd = IPDAdmission::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'department_id' => $request->department_id,
            'ward_id' => $request->ward_id,
            'room_id' => $request->room_id,
            'bed_id' => $request->bed_id,
            'admission_type' => $request->admission_type ?? 'planned',
            'admission_date' => $request->admission_date ?? now(),
            'advance_amount' => $request->advance_amount ?? 0,
            'created_by' => 1
        ]);

        $bed->update(['status' => 'occupied']);

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Admission created',
            'data' => $ipd
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
public function apiView($id)
{
    $ipd = \App\Models\IPDAdmission::with([
        'patient',
        'doctor',
        'department',
        'bed.room',
        'bed.ward'
    ])->find($id);

    if (!$ipd) {
        return response()->json([
            'status' => false,
            'message' => 'IPD not found'
        ], 404);
    }

    return response()->json([
        'status' => true,
        'data' => [
            'id' => $ipd->id,

            // ✅ IMPORTANT IDS
            'patient_id' => $ipd->patient_id,
            'doctor_id' => $ipd->doctor_id,
            'department_id' => $ipd->department_id,
            'ward_id' => $ipd->ward_id,
            'room_id' => $ipd->room_id,
            'bed_id' => $ipd->bed_id,

            // ✅ DISPLAY DATA
            'admission_id' => $ipd->admission_id,              
            'admission_date' => $ipd->admission_date,          
            'admission_type' => $ipd->admission_type,          
            'status' => $ipd->status,                          

            'patient_name' => $ipd->patient->first_name ?? '',
            'doctor' => $ipd->doctor->name ?? '',
            'department' => $ipd->department->department_name ?? '',
            'ward' => $ipd->bed->ward->ward_name ?? '',
            'room' => $ipd->bed->room->room_number ?? '',
            'bed_code' => $ipd->bed->bed_code ?? '',

            'advance_amount' => $ipd->advance_amount,
            'notes' => $ipd->notes,
            'insurance_flag' => $ipd->insurance_flag,
            'insurance_provider' => $ipd->insurance_provider,
            'policy_number' => $ipd->policy_number,
        ]
    ]);
}
public function apiUpdate(Request $request, $id)
{
    DB::beginTransaction();

    try {

        $ipd = IPDAdmission::find($id);

        if (!$ipd) {
            return response()->json([
                'status' => false,
                'message' => 'Not found'
            ], 404);
        }

        if ($ipd->status === 'discharged') {
            return response()->json([
                'status' => false,
                'message' => 'Cannot edit discharged patient'
            ], 400);
        }

        if ($ipd->bed_id != $request->bed_id) {

            $newBed = Bed::findOrFail($request->bed_id);

            if ($newBed->status === 'occupied') {
                return response()->json([
                    'status' => false,
                    'message' => 'Bed occupied'
                ], 400);
            }

            if ($ipd->bed_id) {
                Bed::where('id', $ipd->bed_id)
                    ->update(['status' => 'available']);
            }

            $newBed->update(['status' => 'occupied']);
        }

        $ipd->update($request->all());

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Updated successfully'
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
public function apiDischarge($id)
{
    DB::beginTransaction();

    try {

        $ipd = IPDAdmission::find($id);

        if (!$ipd) {
            return response()->json([
                'status' => false,
                'message' => 'Not found'
            ], 404);
        }

        if ($ipd->status === 'discharged') {
            return response()->json([
                'status' => false,
                'message' => 'Already discharged'
            ], 400);
        }

        if ($ipd->bed_id) {
            Bed::where('id', $ipd->bed_id)
                ->update(['status' => 'available']);
        }

        $ipd->update([
            'status' => 'discharged',
            'discharge_date' => now()
        ]);

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Patient discharged'
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

public function apiPatients()
{
    $patients = \App\Models\Patient::select(
        'id',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth'
    )->get();

    return response()->json([
        'status' => true,
        'data' => $patients
    ]);
}
public function apiDoctors()
{
    // get doctor role
    $doctorRole = \App\Models\Roles::where('name', 'doctor')->first();

    $doctors = \App\Models\Staff::where('role_id', $doctorRole->id)
        ->select('id', 'name')
        ->get();

    return response()->json([
        'status' => true,
        'data' => $doctors
    ]);
}
public function apiBeds(Request $request)
{
    $query = \App\Models\Bed::with(['ward', 'room']);

    if ($request->room_id) {
        $query->where('room_id', $request->room_id);
    }

    $beds = $query->get()->map(function ($bed) {
        return [
            'id' => $bed->id,
            'bed_code' => $bed->bed_code,
            'ward' => $bed->ward->ward_name ?? '',
            'room' => $bed->room->room_number ?? '',
        ];
    });

    return response()->json([
        'status' => true,
        'data' => $beds
    ]);
}
public function apiDepartments()
{
    $departments = \App\Models\Department::select(
        'id',
        'department_name'
    )->get();

    return response()->json([
        'status' => true,
        'data' => $departments
    ]);
}
public function apiWards()
{
    $wards = \App\Models\Ward::select(
        'id',
        'ward_name'
    )->get();

    return response()->json([
        'status' => true,
        'data' => $wards
    ]);
}
public function apiRooms()
{
    $rooms = \App\Models\Room::select(
        'id',
        'room_number',
        'ward_id'
    )->get();

    return response()->json([
        'status' => true,
        'data' => $rooms
    ]);
}
}